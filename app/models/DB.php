<?php
class DB {
  protected static $db;
  protected static $tabla;

  public static function initDB(): void {
    self::$db = mysqli_connect(
      ENV::get('DB_HOST', 'localhost'),
      ENV::get('DB_USER', 'root'),
      ENV::get('DB_PASS', ''),
      ENV::get('DB_NAME', 'pruebas'),
      ENV::get('DB_PORT', '3306')
    );

    if (!self::$db) {
      echo "Error: No se pudo conectar a MySQL.";
      echo "errno de depuración: " . mysqli_connect_errno();
      echo "error de depuración: " . mysqli_connect_error();
      exit;
    };
  }

  protected static function query(string $sql, array $params = [], string $types = ''): mysqli_result|int {
    $stmt = self::$db->prepare($sql);

    if (!$stmt) {
      die("Error en prepare: " . self::$db->error . "\nSQL: " . $sql);
    }

    if (!empty($params)) {
      if (empty($types)) {
        $types = '';
        foreach ($params as $param) {
          $types .= is_int($param) ? 'i' : (is_float($param) ? 'd' : 's');
        }
      }

      $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result instanceof mysqli_result) {
      $stmt->close();
      return $result;
    }

    $affected = $stmt->affected_rows;
    $stmt->close();
    return $affected;
  }

  public static function all(string $orderBy = 'id', string $order = 'ASC', array $columns = ['*']): array {
    $columnas = implode(',', $columns);

    $sql = "SELECT $columnas FROM " . static::$tabla . " ORDER BY $orderBy $order;";
    $result = self::query($sql);

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public static function where(int | string $value, array $columns = ['*'], string $keyId = 'id', string $operator = '='): array {
    $columnas = implode(',', $columns);

    $sql = "SELECT $columnas FROM " . static::$tabla . " WHERE $keyId $operator ?;";
    $result = self::query($sql, [$value]);

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public static function whereMultiple(array $conditions = [], string $logic = 'AND', array $columns = ['*']): array {
    $cols = implode(',', $columns);
    $whereClauses = [];
    $params = [];

    foreach ($conditions as $column => $value) {
      if (is_array($value)) {
        [$operator, $val] = $value;

        if ($operator === 'IN') {
          $placeholders = implode(',', array_fill(0, count($val), '?'));
          $whereClauses[] = "$column IN ($placeholders)";
          $params = array_merge($params, $val);
        } else {
          $whereClauses[] = "$column $operator ?";
          $params[] = $val;
        }
      } else {
        $whereClauses[] = "$column = ?";
        $params[] = $value;
      }
    }

    $where = implode(" $logic ", $whereClauses);
    $sql = "SELECT $cols FROM " . static::$tabla . " WHERE $where;";

    $result = self::query($sql, $params);
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public static function find(int | string $id, array $columns = ['*'], string $keyId = 'id'): ?array {
    $columnas = implode(',', $columns);

    $sql = "SELECT $columnas FROM " . static::$tabla . " WHERE $keyId = ? LIMIT 1;";
    $result = self::query($sql, [$id]);

    $row = $result->fetch_assoc();
    return $row ?: null;
  }

  public static function create(array $columns): int {
    $campos = implode(', ', array_keys($columns));
    $valores = array_values($columns);
    $placeholders = implode(', ', array_fill(0, count($columns), '?'));

    $sql = "INSERT INTO " . static::$tabla . " ($campos) VALUES ($placeholders);";
    return self::query($sql, $valores);
  }

  public static function update(int | string $id, array $columns = [], string $keyId = 'id'): bool {
    $campos = [];
    foreach (array_keys($columns) as $campo) {
      $campos[] = "$campo = ?";
    }

    $sql = 'UPDATE ' . static::$tabla . ' SET ' . implode(', ', $campos) . " WHERE $keyId = ?;";

    $valores = array_values($columns);
    $valores[] = $id;
    $result = self::query($sql, $valores);

    return $result > 0;
  }

  public static function delete(int | string $id, string $keyId = 'id'): bool {
    $sql = 'DELETE FROM ' . static::$tabla . " WHERE $keyId = ?;";
    $result = self::query($sql, [$id]);

    return $result > 0;
  }
}