<?php

/**
 * 
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *
 */
class SaaS_Configuration extends Pluf_Model
{

    public $data = array();

    public $touched = false;

    /**
     * @brief مدل داده‌ای را بارگذاری می‌کند.
     *
     * @see Pluf_Model::init()
     */
    function init ()
    {
        $this->_a['table'] = 'saas_configuration';
        $this->_a['model'] = 'SaaS_Configuration';
        $this->_model = 'SaaS_Configuration';
        
        $this->_a['cols'] = array(
                'id' => array(
                        'type' => 'Pluf_DB_Field_Sequence',
                        'blank' => true,
                        'editable' => false
                ),
                'tenant' => array(
                        'type' => 'Pluf_DB_Field_Foreignkey',
                        'model' => 'SaaS_Application',
                        'blank' => false,
                        'relate_name' => 'tenant',
                        'editable' => false
                ),
                'type' => array(
                        'type' => 'Pluf_DB_Field_Integer',
                        'blank' => false,
                        'editable' => false
                ),
                'key' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => false,
                        'size' => 250,
                        'editable' => false
                ),
                'value' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => true,
                        'size' => 250
                ),
                'description' => array(
                        'type' => 'Pluf_DB_Field_Varchar',
                        'blank' => false,
                        'size' => 250
                ),
                'creation_dtime' => array(
                        'type' => 'Pluf_DB_Field_Datetime',
                        'blank' => true,
                        'verbose' => __('creation date'),
                        'help_text' => __('Creation date of the configuration.')
                ),
                'modif_dtime' => array(
                        'type' => 'Pluf_DB_Field_Datetime',
                        'blank' => true,
                        'verbose' => __('modification date'),
                        'help_text' => __(
                                'Modification date of the configuration.')
                )
        );
        $this->_a['idx'] = array(
                'key_idx' => array(
                        'type' => 'unique',
                        'col' => 'tenant, type, key'
                )
        );
        $this->_a['views'] = array(
                'list' => array(
                        'select' => 'id, saas_configuration.key, description, creation_dtime, modif_dtime'
                )
        );
    }

    /**
     * تعیین یک داده در تنظیم‌ها
     *
     * @param
     *            کلید داده
     * @param
     *            داده مورد نظر. در صورتی که مقدار آن تهی باشد به معنی
     *            حذف است.
     */
    function setData ($key, $value = null)
    {
        if (is_null($value)) {
            unset($this->data[$key]);
        } else {
            $this->data[$key] = $value;
        }
        $this->touched = true;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Pluf_Model::getData()
     */
    function getData ($key = null, $default = '')
    {
        if (is_null($key)) {
            return parent::getData();
        }
        if (isset($this->data[$key])) {
            return $this->data[$key];
        } else {
            return $default;
        }
    }

    /**
     * تمام داده‌های موجود را پاک می‌کند.
     */
    function clear ()
    {
        $this->data = array();
        $this->touched = true;
    }

    /**
     * \brief پیش ذخیره را انجام می‌دهد
     *
     * @param $create حالت
     *            ساخت یا به روز رسانی را تعیین می‌کند
     */
    function preSave ($create = false)
    {
        $this->value = serialize($this->data);
        if ($this->id == '') {
            $this->creation_dtime = gmdate('Y-m-d H:i:s');
        }
        $this->modif_dtime = gmdate('Y-m-d H:i:s');
    }

    /**
     * (non-PHPdoc)
     *
     * @see Pluf_Model::restore()
     */
    function restore ()
    {
        $this->data = unserialize($this->value);
    }

    /**
     * Check if a user is anonymous.
     *
     * @return bool True if the user is anonymous.
     */
    function isStored ()
    {
        return (0 === (int) $this->id);
    }
}