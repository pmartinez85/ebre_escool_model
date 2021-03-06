<?php

namespace Scool\EbreEscoolModel;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Scool\EbreEscoolModel\Traits\Periodable;

/**
 * Class StudyModule.
 *
 * @package Scool\EbreEscoolModel
 */
class StudyModule extends EloquentModel
{
    use Periodable;

    /**
     * @var string
     */
    protected $table = 'study_module';

    /**
     * @var string
     */
    protected $primaryKey = 'study_module_id';

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($this->getAttribute($key)) {
            $attribute = $this->getAttribute($key);
        } else {
            if ($this->getAttribute('study_module_' .$key)) {
                $attribute = $this->getAttribute('study_module_' .$key);
            } else {
                $attribute = $this->getAttributeInPeriod($key);
            }
        }

        return $attribute;
    }

    /**
     *
     * Search for attribute in current period.
     *
     * @param $key
     */
    public function getAttributeInPeriod($key)
    {
        if ($attribute = $this->modulesByPeriod()->active()->first()->getAttribute($key)) {
            return $attribute;
        }
        return $this->modulesByPeriod()->active()->first()->getAttribute('study_module_academic_periods_' .$key);
    }

    /**
     * Get modules info by periods.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modulesByPeriod()
    {
        return $this->hasMany(StudyModuleAcademicPeriod::class,
            'study_module_academic_periods_study_module_id', 'study_module_id'
            );
    }

    /**
     * Get the study periods.
     */
    public function periods()
    {
        return $this->belongsToMany(AcademicPeriod::class, 'study_module_academic_periods',
            'study_module_academic_periods_study_module_id', 'study_module_academic_periods_academic_period_id');
    }

    public function submodules()
    {
        return $this->hasMany(StudySubModule::class,
            'study_submodules_study_module_id', 'study_module_id'
        );
    }

}
