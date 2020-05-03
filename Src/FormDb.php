<?php
namespace App;

class FormDb
{
    const MAIN_TABLE = 'vue_registration_form';

    /**
     * @param array $data
     * @param null|array $format
     * 
     * @return void
     */
    public function insert(array $data, array $format = null) : void
    {
        global $wpdb;
        $wpdb->insert($this->getMainTable(), $data, $format);
    }

    /**
     * @param string $field
     * @param string $value
     * 
     * @return array|null
     */
    public function select(string $field, string $value)
    {
        global $wpdb;
        $sql = sprintf("SELECT * FROM %s WHERE %s = '%s'", $this->getMainTable(), $field, $value);
        return $wpdb->get_row($wpdb->prepare($sql), ARRAY_A);
    }

    /**
     * @return string
     */
    private function getMainTable() : string
    {
        global $wpdb;
        return $wpdb->prefix . self::MAIN_TABLE;
    }
}