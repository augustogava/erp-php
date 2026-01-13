<?php
if (!function_exists('mysql_connect')) {
    
    $GLOBALS['__mysql_compat_link'] = null;

    function mysql_connect($server, $username, $password) {
        $GLOBALS['__mysql_compat_link'] = @mysqli_connect($server, $username, $password);
        return $GLOBALS['__mysql_compat_link'];
    }

    function mysql_select_db($database, $link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_select_db($link, $database);
    }

    function mysql_query($query, $link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_query($link, $query);
    }

    function mysql_fetch_array($result, $type = MYSQLI_BOTH) {
        if (!$result) return null;
        return @mysqli_fetch_array($result, $type);
    }

    function mysql_fetch_assoc($result) {
        if (!$result) return null;
        return @mysqli_fetch_assoc($result);
    }

    function mysql_fetch_row($result) {
        if (!$result) return null;
        return @mysqli_fetch_row($result);
    }

    function mysql_num_rows($result) {
        if (!$result) return 0;
        return @mysqli_num_rows($result);
    }

    function mysql_affected_rows($link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_affected_rows($link);
    }

    function mysql_insert_id($link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_insert_id($link);
    }

    function mysql_real_escape_string($string, $link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        if (!$link) return addslashes($string);
        return @mysqli_real_escape_string($link, $string);
    }

    function mysql_escape_string($string) {
        return mysql_real_escape_string($string);
    }

    function mysql_error($link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        if (!$link) return '';
        return @mysqli_error($link);
    }

    function mysql_errno($link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        if (!$link) return 0;
        return @mysqli_errno($link);
    }

    function mysql_close($link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_close($link);
    }

    function mysql_free_result($result) {
        if (!$result) return false;
        return @mysqli_free_result($result);
    }

    function mysql_data_seek($result, $row) {
        if (!$result) return false;
        return @mysqli_data_seek($result, $row);
    }

    function mysql_fetch_object($result, $class = 'stdClass') {
        if (!$result) return null;
        return @mysqli_fetch_object($result, $class);
    }

    function mysql_num_fields($result) {
        if (!$result) return 0;
        return @mysqli_num_fields($result);
    }

    function mysql_field_name($result, $field_offset) {
        if (!$result) return false;
        $info = @mysqli_fetch_field_direct($result, $field_offset);
        return $info ? $info->name : false;
    }

    function mysql_list_tables($database, $link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_query($link, "SHOW TABLES FROM `" . mysqli_real_escape_string($link, $database) . "`");
    }

    function mysql_tablename($result, $i) {
        if (!$result) return false;
        @mysqli_data_seek($result, $i);
        $row = @mysqli_fetch_row($result);
        return $row ? $row[0] : false;
    }

    function mysql_set_charset($charset, $link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_set_charset($link, $charset);
    }

    function mysql_ping($link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_ping($link);
    }

    function mysql_get_server_info($link = null) {
        $link = $link ?: $GLOBALS['__mysql_compat_link'];
        return @mysqli_get_server_info($link);
    }

    function mysql_result($result, $row, $field = 0) {
        if (!$result) return false;
        @mysqli_data_seek($result, $row);
        $data = @mysqli_fetch_array($result);
        return isset($data[$field]) ? $data[$field] : false;
    }
}

if (!function_exists('ereg_replace')) {
    function ereg_replace($pattern, $replacement, $string) {
        return preg_replace('/' . $pattern . '/', $replacement, $string);
    }
}

if (!function_exists('ereg')) {
    function ereg($pattern, $string, &$regs = null) {
        return preg_match('/' . $pattern . '/', $string, $regs);
    }
}

if (!function_exists('eregi')) {
    function eregi($pattern, $string, &$regs = null) {
        return preg_match('/' . $pattern . '/i', $string, $regs);
    }
}

if (!function_exists('split')) {
    function split($pattern, $string, $limit = -1) {
        return preg_split('/' . $pattern . '/', $string, $limit);
    }
}
?>