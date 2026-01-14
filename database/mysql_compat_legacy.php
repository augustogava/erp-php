<?php
/**
 * mysql_* compatibility layer for PHP 8.2.
 * TEMPORARY ONLY — remove once all files are migrated to Database/QueryBuilder.
 *
 * This file intentionally avoids fatal errors by providing wrappers to mysqli.
 */
declare(strict_types=1);

if (!function_exists('mysql_connect')) {
    $GLOBALS['__mysql_compat_link'] = null;

    function mysql_connect($host, $user, $password)
    {
        $GLOBALS['__mysql_compat_link'] = @mysqli_connect($host, $user, $password);
        return $GLOBALS['__mysql_compat_link'];
    }

    function mysql_select_db($database, $link = null)
    {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_select_db($link, $database);
    }

    function mysql_query($query, $link = null)
    {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_query($link, $query);
    }

    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH)
    {
        if (!$result) {
            return null;
        }
        return @mysqli_fetch_array($result, $result_type);
    }

    function mysql_fetch_assoc($result)
    {
        if (!$result) {
            return null;
        }
        return @mysqli_fetch_assoc($result);
    }

    function mysql_fetch_row($result)
    {
        if (!$result) {
            return null;
        }
        return @mysqli_fetch_row($result);
    }

    function mysql_num_rows($result)
    {
        if (!$result) {
            return 0;
        }
        return @mysqli_num_rows($result);
    }

    function mysql_affected_rows($link = null)
    {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_affected_rows($link);
    }

    function mysql_insert_id($link = null)
    {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_insert_id($link);
    }

    function mysql_real_escape_string($string, $link = null)
    {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        if (!$link) {
            return addslashes((string)$string);
        }
        return @mysqli_real_escape_string($link, (string)$string);
    }

    function mysql_escape_string($string)
    {
        return mysql_real_escape_string($string);
    }

    function mysql_error($link = null)
    {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        if (!$link) {
            return '';
        }
        return @mysqli_error($link);
    }

    function mysql_errno($link = null)
    {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        if (!$link) {
            return 0;
        }
        return @mysqli_errno($link);
    }

    function mysql_close($link = null)
    {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_close($link);
    }

    function mysql_free_result($result)
    {
        if (!$result) {
            return false;
        }
        return @mysqli_free_result($result);
    }

    function mysql_data_seek($result, $row_number)
    {
        if (!$result) {
            return false;
        }
        return @mysqli_data_seek($result, (int)$row_number);
    }

    function mysql_fetch_object($result, $class_name = 'stdClass')
    {
        if (!$result) {
            return null;
        }
        return @mysqli_fetch_object($result, (string)$class_name);
    }

    function mysql_num_fields($result)
    {
        if (!$result) {
            return 0;
        }
        return @mysqli_num_fields($result);
    }

    function mysql_field_name($result, $field_offset)
    {
        if (!$result) {
            return false;
        }
        $info = @mysqli_fetch_field_direct($result, (int)$field_offset);
        return $info ? $info->name : false;
    }

    function mysql_set_charset($charset, $link = null)
    {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_set_charset($link, (string)$charset);
    }
}

