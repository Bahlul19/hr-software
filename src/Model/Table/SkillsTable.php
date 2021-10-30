<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;

/**
 * Skills Model
 *
 * @property \App\Model\Table\EmployeeSkillsTable|\Cake\ORM\Association\HasMany $EmployeeSkills
 *
 * @method \App\Model\Entity\Skill get($primaryKey, $options = [])
 * @method \App\Model\Entity\Skill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Skill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Skill|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Skill|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Skill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Skill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Skill findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SkillsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('skills');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('EmployeeSkills', [
            'foreignKey' => 'skill_id'
        ]);
        $this->belongsTo('SkillCategories', [
            'foreignKey' => 'skill_category_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('skill_name')
            ->maxLength('skill_name', 100)
            ->requirePresence('skill_name', 'create')
            ->notEmpty('skill_name');

        $validator
            ->scalar('skill_level_ids')
            ->maxLength('skill_level_ids', 30)
            ->requirePresence('skill_level_ids', 'create')
            ->notEmpty('skill_level_ids');

        $validator
            ->scalar('version')
            ->maxLength('version', 10)
            ->allowEmpty('version');

        $validator
            ->scalar('image')
            ->maxLength('image', 100)
            ->allowEmpty('image');

        return $validator;
    }

    public function uploadImage($image=null,$skill_name=null,$version=null){
        $mainImagePath=Configure::read('imagepath');
            if($image['tmp_name']!="" && !empty($image)){
                $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                $extenstions=['png','jpg'];

                if(in_array($ext, $extenstions)){
                        $path=getcwd().DS.$mainImagePath.DS.$skill_name;
                        $folder = new Folder($path);
                            if (is_null($folder->path)) {
                                $folderNew = new Folder();
                                $folderNew->create($path);
                            }
                            $uploadFile = $path.DS.$skill_name."_".$version.".".$ext;
                            if(move_uploaded_file($image['tmp_name'],$uploadFile))
                            {
                                $return=$mainImagePath."/".$skill_name."/".$skill_name."_".$version.".".$ext;
                            }else{
                                $return=3;
                            }
                    }else{
                        $return= 2;
                    }
            }else{
                $return= 1;
            }

            return $return;
        }
}
