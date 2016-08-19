<?php
/**
 * WellCart Platform
 *
 * @copyright  Copyright (c) 2016 WellCart Development Team    http://wellcart.org/
 * @license    http://www.opensource.org/licenses/BSD-3-Clause New BSD License
 */

declare(strict_types = 1);

namespace WellCart\SchemaMigration\Db;

use Phinx\Db\Table as AbstractTable;

class Table extends AbstractTable
{
    /**
     * Insert a new record(s) into the database.
     *
     * @param  array $values
     *
     * @return bool
     */
    public function seed(array $values)
    {
        $this->reset();
        $tableName = $this->getName();

        // Since every insert gets treated like a batch insert, we will make sure the
        // bindings are structured in a way that is convenient for building these
        // inserts statements by verifying the elements are actually an array.
        if (!is_array(reset($values))) {
            $values = [$values];
        } // Since every insert gets treated like a batch insert, we will make sure the
        // bindings are structured in a way that is convenient for building these
        // inserts statements by verifying the elements are actually an array.
        else {
            foreach ($values as $key => $value) {
                ksort($value);
                $values[$key] = $value;
            }
        }

        $columns = array_keys(reset($values));

        $pdo = $this->getAdapter()->getConnection();

        $placeholder = function ($text, $count = 0, $separator = ',') {
            $result = [];

            if ($count > 0) {
                for ($x = 0; $x < $count; $x++) {
                    $result[] = $text;
                }
            }

            return implode($separator, $result);
        };

        $pdo->beginTransaction();

        $insertValues = $questionMarks = [];

        foreach ($values as $row) {
            $questionMarks[] = '(' . $placeholder('?', sizeof($row)) . ')';
            $insertValues = array_merge($insertValues, array_values($row));
        }

        $sql = "INSERT INTO $tableName (" . implode(',', $columns) . ") VALUES "
            . implode(',', $questionMarks);

        $statement = $pdo->prepare($sql);
        $statement->execute($insertValues);
        $pdo->commit();
    }
}
