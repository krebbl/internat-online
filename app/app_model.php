<?php
/* SVN FILE: $Id: app_model.php 7945 2008-12-19 02:16:01Z gwoo $ */

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision: 7945 $
 * @modifiedby    $LastChangedBy: gwoo $
 * @lastmodified  $Date: 2008-12-18 18:16:01 -0800 (Thu, 18 Dec 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
	
	public function find($type, $options = array()) { 
        if (!isset($options['joins'])) { 
            $options['joins'] = array(); 
        } 

        switch ($type) { 
            case 'matches': 
                if (!isset($options['model']) || !isset($options['scope'])) { 
                    break; 
                } 
                $assoc = $this->hasAndBelongsToMany[$options['model']]; 
                $bind = "{$assoc['with']}.{$assoc['foreignKey']} = {$this->alias}.{$this->primaryKey}"; 

                $options['joins'][] = array( 
                    'table' => $assoc['joinTable'], 
                    'alias' => $assoc['with'], 
                    'type' => 'inner', 
                    'foreignKey' => false, 
                    'conditions'=> array($bind) 
                ); 

                $bind = $options['model'] . '.' . $this->{$options['model']}->primaryKey . ' = '; 
                $bind .= "{$assoc['with']}.{$assoc['associationForeignKey']}"; 

                $options['joins'][] = array( 
                    'table' => $this->{$options['model']}->table, 
                    'alias' => $options['model'], 
                    'type' => 'inner', 
                    'foreignKey' => false, 
                    'conditions'=> array($bind) + (array)$options['scope'], 
                ); 
                unset($options['model'], $options['scope']); 
                $type = 'all'; 
            break; 
        } 
        return parent::find($type, $options); 
    } 
    
    function afterFind($results)  
    {  
        if (isset($this->__runResetExpects) && $this->__runResetExpects) 
        { 
            $this->__resetExpects(); 
            unset($this->__runResetExpects); 
        } 
         
        return parent::afterFind($results); 
    } 
     
    /** 
     * Unbinds all relations from a model except the specified ones. Calling this function without 
     * parameters unbinds all related models. 
     *  
     * @access public 
     * @since 1.0 
     */ 
    function expects()  
    {  
        $models = array(); 
        $arguments = func_get_args(); 
        $innerCall = false; 

        if (!empty($arguments) && is_bool($arguments[0])) 
        { 
            $innerCall = $arguments[0]; 
        } 
         
        foreach($arguments as $index => $argument)  
        {  
            if (is_array($argument))  
            {  
                if (count($argument) > 0)  
                {  
                    $arguments = am($arguments, $argument);  
                }  

                unset($arguments[$index]);  
            } 
        } 
         
        foreach($arguments as $index => $argument) 
        { 
            if (!is_string($argument)) 
            { 
                unset($arguments[$index]); 
            } 
        } 

        if (count($arguments) == 0)  
        {  
            $models[$this->name] = array();  
        }  
        else  
        {  
            foreach($arguments as $argument)  
            {  
                if (strpos($argument, '.') !== false)  
                {  
                    $model = substr($argument, 0, strpos($argument, '.'));  
                    $child = substr($argument, strpos($argument, '.') + 1);  

                    if ($child == $model)  
                    { 
                        $models[$model] = array();  
                    }  
                    else  
                    {  
                        $models[$model][] = $child;  
                    }  
                } 
                else  
                {  
                    $models[$this->name][] = $argument;  
                }  
            }  
        } 
         
        $relationTypes = array ('belongsTo', 'hasOne', 'hasMany', 'hasAndBelongsToMany'); 

        foreach($models as $bindingName => $children)  
        { 
            $model = null; 
             
            foreach($relationTypes as $relationType)  
            {  
                $currentRelation = (isset($this->$relationType) ? $this->$relationType : null); 
                 
                if (isset($currentRelation) && isset($currentRelation[$bindingName]) && is_array($currentRelation[$bindingName]) && isset($currentRelation[$bindingName]['className']))  
                { 
                    $model = $currentRelation[$bindingName]['className']; 
                    break; 
                } 
            } 
             
            if (!isset($model)) 
            { 
                $model = $bindingName; 
            } 
             
            if (isset($model) && $model != $this->name && isset($this->$model))  
            { 
                if (!isset($this->__backInnerAssociation)) 
                { 
                    $this->__backInnerAssociation = array(); 
                }  
                 
                $this->__backInnerAssociation[] = $model; 
                 
                $this->$model->expects(true, $children); 
            }  
        } 
         
        if (isset($models[$this->name]))  
        {  
            foreach($models as $model => $children)  
            {  
                if ($model != $this->name)  
                {  
                    $models[$this->name][] = $model;  
                }  
            }  
     
            $models = array_unique($models[$this->name]); 
            $unbind = array();  
     
            foreach($relationTypes as $relation)  
            {  
                if (isset($this->$relation))  
                {  
                    foreach($this->$relation as $bindingName => $bindingData) 
                    {  
                        if (!in_array($bindingName, $models)) 
                        {  
                            $unbind[$relation][] = $bindingName;  
                        }  
                    }  
                }  
            }  
     
            if (count($unbind) > 0)  
            {  
                $this->unbindModel($unbind);  
            } 
        } 

        if (!$innerCall) 
        { 
            $this->__runResetExpects = true; 
        } 
    } 
     
    /** 
     * Resets all relations and inner model relations after calling expects() and find(). 
     *  
     * @access private 
     * @since 1.1 
     */ 
    function __resetExpects() 
    { 
        if (isset($this->__backAssociation)) 
        { 
            $this->__resetAssociations(); 
        } 
         
        if (isset($this->__backInnerAssociation)) 
        { 
            foreach($this->__backInnerAssociation as $model) 
            { 
                $this->$model->__resetExpects(); 
            } 
             
            unset($this->__backInnerAssociation); 
        } 
    }
	
	/**
	 * Creates and validates. The Validation errors are merged to the validationErrorsReference
	 * 
	 * @param object $data
	 * @param object $validationErrors
	 * @return Returns TRUE on success
	 */
	function createAndValidate($data,&$validationErrors = FALSE, &$success = NULL){
		parent::create($data);
		$is_valid = $this->validates();
		if($validationErrors !== FALSE){
			if(!isset($validationErrors)){
				$validationErrors = array();
			}
			$validationErrors = array_merge($validationErrors,$this->validationErrors);	
		}
		if($success != NULL && !$is_valid){
			$success = $is_valid;
		}
		return $is_valid;
	}
	
}
?>