<?php
require 'MyPDO.php';

class MysqlCsv
{
    private string $delimiter = ";";
    private string $enclosure = '"';
    private string $table = "product";

    private MyPDO $pdo;

    public function __construct($connection = null, $table = null, $delimiter = null, $enclosure = null)
    {
        $this->pdo = $connection ?: new MyPDO();

        if($table) $this->table = $table;
        if ($delimiter) $this->delimiter = $delimiter;
        if ($enclosure) $this->enclosure = $enclosure;
    }

    public function get_array($file)
    {
        if (!is_file($file)) {
            die("CSV Parse Failed: Passed $file which does not exist or is not readable by the server");
        }

        $csv_arr = array();
        $input = fopen($file, 'r');

        $csv_arr['headers'] = fgetcsv($input, 0, $this->delimiter, $this->enclosure);

        while ($row = fgetcsv($input, 0, $this->delimiter, $this->enclosure)) {
            foreach ($csv_arr['headers'] as $header_key => $header_value) {
                $n_row[$header_value] = $row[$header_key];
            }
            $csv_arr['rows'][] = $this->clearRow($n_row);
        }
        fclose($input);

        return $csv_arr;
    }

    private function clearRow($row)
    {
        if (empty($row['small_text'])) {
            $row['small_text'] = substr($row['big_text'], 0, 30);
        }
        $row['small_text'] = strip_tags($row['small_text']);
        $row["user_id"] = $_SESSION["user_id"];

        return $row;
    }

    public function import($file): string
    {
        $csv = $this->get_array($file);

        $countUpd = 0;
        $countIns = 0;

        foreach ($csv["rows"] as $row) {
            if ($this->rowExists($row)) {
                $countUpd += $this->updateSQL($this->table, $row, "where id = $row[id] and user_id = $row[user_id]");
            } else {
                $countIns += $this->insertSQL($this->table, $row);
            }
        }

        return "Добавлено $countIns. Обновлено $countUpd";
    }

    private function rowExists($row)
    {
        return $this->selectSQL($this->table, "*", "where id = $row[id] and user_id = $row[user_id]");
    }

    public function export(): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=export.csv");
        $output = fopen("php://output", "w");

        $columns = $this->selectSQL("INFORMATION_SCHEMA.COLUMNS", "*", "where TABLE_NAME='$this->table'");
        $col_arr = array();
        foreach ($columns as $column) {
            $col_arr[] = $column['COLUMN_NAME'];
        }
        fputcsv($output, $col_arr, $this->delimiter, $this->enclosure);

        $rows = $this->selectSQL($this->table, "*", "");
        foreach ($rows as $row) {
            fputcsv($output, $row, $this->delimiter, $this->enclosure);
        }

        fclose($output);
    }

    private function insertSQL(string $table, array $valueArr)
    {
        foreach ($valueArr as $key => $value) {
            $args[] = $key . '=:' . $key;
        }
        $set_args = implode(', ', $args);

        $query = "insert into $table set $set_args";
        return $this->staticSQL($query, $valueArr);
    }

    private function updateSQL(string $table, array $valueArr, string $extras)
    {
        foreach ($valueArr as $key => $value) {
            $args[] = $key . '=:' . $key;
        }
        $set_args = implode(', ', $args);

        $query = "update $table set $set_args $extras";
        return $this->staticSQL($query, $valueArr);
    }

    private function staticSQL(string $baseQuery, array $array = null)
    {
        if ($array == null) {
            if (!$this->pdo->query($baseQuery)->fetchAll()) {
                die();
            }
        } else {
            $stmt = $this->_prepare_stmt($baseQuery, $array);
            $stmt->execute();
            return $stmt->rowCount();
        }
        return 0;
    }


    private function selectSQL(string $table, string $columns, string $extras, array $array = null)
    {
        return $this->arraySQL("SELECT $columns FROM $table $extras", $array);
    }

    private function arraySQL(string $baseQuery, array $array = null)
    {
        $res = null;
        if ($array == null) {
            $res = $this->pdo->query($baseQuery);
            if (!$res) {
                die();
            }
        } else {
            $res = $this->_prepare_stmt($baseQuery, $array);
            $res->execute();
        }
        $arr = array();
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $arr[] = $row;
        }
        return $arr;
    }

    private function _prepare_stmt(string $baseQuery, array $array = null)
    {
        $count = substr_count($baseQuery, ":");
        if ($count > 0 && $array == null) {
            die("Number of parameters and variables do not match");
        }

        $stmt = $this->pdo->prepare($baseQuery);
        if (!$stmt) {
            die();
        }

        if ($array != null) {
            if ($count != sizeof($array)) {
                die("Wrong number of arguments");
            }
            foreach ($array as $key => &$value) {
                $stmt->bindParam($key, $value);
            }
        }

        return $stmt;
    }
}