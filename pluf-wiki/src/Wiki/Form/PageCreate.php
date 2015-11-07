<?php

/**
 * ایجاد یک صفحه ویکی جدید
 *
 * با استفاده از این فرم می‌توان یک صفحه جدید ویکی را ایجاد کرد.
 * 
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *
 */
class Wiki_Form_PageCreate extends Pluf_Form
{

    public $user = null;
    
    // public $project = null;
    
    // public $show_full = false;
    public function initFields ($extra = array())
    {
        $this->user = $extra['user'];
        // $this->project = $extra['project'];
        // if ($this->user->hasPerm('IDF.project-owner', $this->project) or
        // $this->user->hasPerm('IDF.project-member', $this->project)) {
        // $this->show_full = true;
        // }
        $initial = __('empty page');
        $initname = (! empty($extra['name'])) ? $extra['name'] : __('page name');
        $this->fields['title'] = new Pluf_Form_Field_Varchar(
                array(
                        'required' => false,
                        'label' => __('page title'),
                        'initial' => $initname,
                        'widget_attrs' => array(
                                'maxlength' => 200,
                                'size' => 67
                        ),
                        'help_text' => __(
                                'the page name must contains only letters, digits and the dash (-) character')
                ));
        $this->fields['summary'] = new Pluf_Form_Field_Varchar(
                array(
                        'required' => false,
                        'label' => __('Description'),
                        'help_text' => __(
                                'this one line description is displayed in the list of pages'),
                        'initial' => '',
                        'widget_attrs' => array(
                                'maxlength' => 200,
                                'size' => 67
                        )
                ));
        $this->fields['content'] = new Pluf_Form_Field_Varchar(
                array(
                        'required' => false,
                        'label' => __('content'),
                        'initial' => $initial,
                        'widget' => 'Pluf_Form_Widget_TextareaInput',
                        'widget_attrs' => array(
                                'cols' => 68,
                                'rows' => 26
                        )
                ));
        $this->fields['content_type'] = new Pluf_Form_Field_Varchar(
                array(
                        'required' => false,
                        'label' => __('content type'),
                        'initial' => 'text/plain',
                        'widget' => 'Pluf_Form_Widget_TextareaInput',
                        'widget_attrs' => array(
                                'cols' => 68,
                                'rows' => 26
                        )
                ));
        
        // if ($this->show_full) {
        // for ($i = 1; $i < 4; $i ++) {
        // $this->fields['label' . $i] = new Pluf_Form_Field_Varchar(
        // array(
        // 'required' => false,
        // 'label' => __('Labels'),
        // 'initial' => '',
        // 'widget_attrs' => array(
        // 'maxlength' => 50,
        // 'size' => 20
        // )
        // ));
        // }
        // }
    }

//     public function clean_title ()
//     {
//         $title = $this->cleaned_data['title'];
//         if (preg_match('/[^a-zA-Z0-9\-]/', $title)) {
//             throw new Pluf_Form_Invalid(
//                     __('The title contains invalid characters.'));
//         }
//         // $sql = new Pluf_SQL('project=%s AND title=%s',
//         // array(
//         // $this->project->id,
//         // $title
//         // ));
//         // $pages = Pluf::factory('IDF_WikiPage')->getList(
//         // array(
//         // 'filter' => $sql->gen()
//         // ));
//         // if ($pages->count() > 0) {
//         // throw new Pluf_Form_Invalid(
//         // __('A page with this title already exists.'));
//         // }
//         return $title;
//     }
    
    // /**
    // * Validate the interconnection in the form.
    // */
    // public function clean ()
    // {
    // if (! $this->show_full) {
    // return $this->cleaned_data;
    // }
    // $conf = new IDF_Conf();
    // $conf->setProject($this->project);
    // $onemax = array();
    // foreach (explode(',',
    // $conf->getVal('labels_wiki_one_max',
    // IDF_Form_WikiConf::init_one_max)) as $class) {
    // if (trim($class) != '') {
    // $onemax[] = mb_strtolower(trim($class));
    // }
    // }
    // $count = array();
    // for ($i = 1; $i < 4; $i ++) {
    // $this->cleaned_data['label' . $i] = trim(
    // $this->cleaned_data['label' . $i]);
    // if (strpos($this->cleaned_data['label' . $i], ':') !== false) {
    // list ($class, $name) = explode(':',
    // $this->cleaned_data['label' . $i], 2);
    // list ($class, $name) = array(
    // mb_strtolower(trim($class)),
    // trim($name)
    // );
    // } else {
    // $class = 'other';
    // $name = $this->cleaned_data['label' . $i];
    // }
    // if (! isset($count[$class]))
    // $count[$class] = 1;
    // else
    // $count[$class] += 1;
    // if (in_array($class, $onemax) and $count[$class] > 1) {
    // if (! isset($this->errors['label' . $i]))
    // $this->errors['label' . $i] = array();
    // $this->errors['label' . $i][] = sprintf(
    // __(
    // 'You cannot provide more than label from the %s class to a page.'),
    // $class);
    // throw new Pluf_Form_Invalid(__('You provided an invalid label.'));
    // }
    // }
    // return $this->cleaned_data;
    // }
    
    /**
     * Save the model in the database.
     *
     * @param
     *            bool Commit in the database or not. If not, the object
     *            is returned but not saved in the database.
     * @return Object Model with data set from the form.
     */
    function save ($commit = true)
    {
        if (! $this->isValid()) {
            throw new Pluf_Exception(
                    __('cannot save the model from an invalid form'));
        }
        // // Add a tag for each label
        // $tags = array();
        // if ($this->show_full) {
        // for ($i = 1; $i < 4; $i ++) {
        // if (strlen($this->cleaned_data['label' . $i]) > 0) {
        // if (strpos($this->cleaned_data['label' . $i], ':') !== false) {
        // list ($class, $name) = explode(':',
        // $this->cleaned_data['label' . $i], 2);
        // list ($class, $name) = array(
        // trim($class),
        // trim($name)
        // );
        // } else {
        // $class = 'Other';
        // $name = trim($this->cleaned_data['label' . $i]);
        // }
        // $tags[] = IDF_Tag::add($name, $this->project, $class);
        // }
        // }
        // }
        // Create the page
        $page = new Wiki_Page();
        // $page->project = $this->project;
        $page->setFromFormData($this->cleaned_data);
        $page->submitter = $this->user;
        
        if ($commit) {
            $page->create();
        }
        // foreach ($tags as $tag) {
        // $page->setAssoc($tag);
        // }
        // add the first revision
        // $rev = new IDF_WikiRevision();
        // $rev->wikipage = $page;
        // $rev->content = $this->cleaned_data['content'];
        // $rev->submitter = $this->user;
        // $rev->summary = __('Initial page creation');
        // $rev->create();
        // $rev->notify($this->project->getConf());
        return $page;
    }
}
