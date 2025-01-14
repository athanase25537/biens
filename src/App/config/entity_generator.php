<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

$host = "localhost";
$table = "bailonline";
$user = "root";
$pdw = "";



class Database {
    private $pdo;

    public function __construct($host, $db, $user, $pass) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function getTables() {
        $stmt = $this->pdo->query("SHOW TABLES");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getTableStructure($table) {
        $stmt = $this->pdo->query("DESCRIBE $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKeys($table) {
        $stmt = $this->pdo->query("SHOW KEYS FROM $table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class EntityGenerator {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function generateEntities() {
        $tables = $this->db->getTables();
        foreach ($tables as $table) {
            $this->generateEntity($table);
            $this->generateRepository($table);
        }
    }

	   private function generateEntity($table) {
		$structure = $this->db->getTableStructure($table);
		$keys = $this->db->getKeys($table);
		$primaryKeys = array_filter($keys, fn($key) => $key['Key_name'] === 'PRIMARY');

		$properties = [];
		$constructorParams = [];
		$constructorBody = [];

		foreach ($structure as $column) {
			$type = $this->getType($column['Type']);
			$isPrimary = in_array($column['Field'], array_column($primaryKeys, 'Column_name')) ? ' // @PrimaryKey' : '';
			$properties[] = "    /**\n     * @var $type\n     */\n    private \${$column['Field']};$isPrimary";

			$constructorParams[] = "$type \${$column['Field']}";
			$constructorBody[] = "        \$this->{$column['Field']} = \${$column['Field']};";
		}

		$constructorCode = "    public function __construct(" . implode(', ', $constructorParams) . ") {\n" . implode("\n", $constructorBody) . "\n    }\n\n";

		$entityCode = "<?php\n\nclass " . ucfirst($table) . " {\n" . implode("\n", $properties) . "\n\n";
		$entityCode .= $constructorCode;

		foreach ($structure as $column) {
			$entityCode .= "    public function get" . ucfirst($column['Field']) . "() {\n        return \$this->{$column['Field']};\n    }\n\n";
			$entityCode .= "    public function set" . ucfirst($column['Field']) . "(\${$column['Field']}) {\n        \$this->{$column['Field']} = \${$column['Field']};\n    }\n\n";
		}

		$entityCode .= "}\n";

		file_put_contents("src/Core/Entities/$table.php", $entityCode);
	}


    private function generateRepository($table) {
        $repositoryCode = "<?php\n\nclass " . ucfirst($table) . "Repository {\n    private \$db;\n\n    public function __construct(Database \$db) {\n        \$this->db = \$db;\n    }\n\n";

        $repositoryCode .= $this->generateFindByIdMethod($table);
        $repositoryCode .= $this->generateFindAllMethod($table);
        $repositoryCode .= $this->generateInsertMethod($table);
        $repositoryCode .= $this->generateUpdateMethod($table);
        $repositoryCode .= $this->generateDeleteMethod($table);
        $repositoryCode .= $this->generateFindByFieldMethod($table);

        $repositoryCode .= "}\n";

        file_put_contents("src/Core/Repository/".$table . "Repository.php", $repositoryCode);
    }

    private function generateFindByIdMethod($table) {
        return "    public function findById(\$id) {\n" .
               "        \$stmt = \$this->db->getPdo()->prepare('SELECT * FROM $table WHERE id = ?');\n" .
               "        \$stmt->execute([\$id]);\n" .
               "        return \$stmt->fetchObject('" . ucfirst($table) . "');\n" .
               "    }\n\n";
    }

    private function generateFindAllMethod($table) {
        return "    public function findAll() {\n" .
               "        \$stmt = \$this->db->getPdo()->query('SELECT * FROM $table');\n" .
               "        return \$stmt->fetchAll(PDO::FETCH_CLASS, '" . ucfirst($table) . "');\n" .
               "    }\n\n";
    }

    private function generateInsertMethod($table) {
        return "    public function insert(\$data) {\n" .
               "        \$columns = array_keys(\$data);\n" .
               "        \$values = array_values(\$data);\n" .
               "        \$placeholders = implode(', ', array_fill(0, count(\$data), '?'));\n\n" .
               "        \$sql = 'INSERT INTO $table (' . implode(', ', \$columns) . ') VALUES (' . \$placeholders . ')';\n" .
               "        \$stmt = \$this->db->getPdo()->prepare(\$sql);\n" .
               "        return \$stmt->execute(\$values);\n" .
               "    }\n\n";
    }

    private function generateUpdateMethod($table) {
        return "    public function update(\$data) {\n" .
               "        \$id = \$data['id'];\n" .
               "        unset(\$data['id']);\n" .
               "        \$setClause = implode(' = ?, ', array_keys(\$data)) . ' = ?';\n\n" .
               "        \$sql = 'UPDATE $table SET ' . \$setClause . ' WHERE id = ?';\n" .
               "        \$stmt = \$this->db->getPdo()->prepare(\$sql);\n" .
               "        return \$stmt->execute([...array_values(\$data), \$id]);\n" .
               "    }\n\n";
    }

    private function generateDeleteMethod($table) {
        return "    public function delete(\$id) {\n" .
               "        \$stmt = \$this->db->getPdo()->prepare('DELETE FROM $table WHERE id = ?');\n" .
               "        return \$stmt->execute([\$id]);\n" .
               "    }\n\n";
    }

    private function generateFindByFieldMethod($table) {
        return "    public function findByField(\$field, \$value) {\n" .
               "        \$stmt = \$this->db->getPdo()->prepare('SELECT * FROM $table WHERE ' . \$field . ' = ?');\n" .
               "        \$stmt->execute([\$value]);\n" .
               "        return \$stmt->fetchAll(PDO::FETCH_CLASS, '" . ucfirst($table) . "');\n" .
               "    }\n\n";
    }

    private function getType($dbType) {
        if (strpos($dbType, 'int') !== false) return 'int';
        if (strpos($dbType, 'varchar') !== false || strpos($dbType, 'text') !== false) return 'string';
        if (strpos($dbType, 'date') !== false || strpos($dbType, 'datetime') !== false) return '\DateTime';
        return 'mixed';
    }
}

// Utilisation
$db = new Database($host, $table, $user, $pdw);
$generator = new EntityGenerator($db);
$generator->generateEntities();

$db->getTables();
