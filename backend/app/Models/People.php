<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/** @property int $id
 * @property string $firstname
 * @property string $surname
 * @property string|null $patronymic
 * @property string $phone_number
 * @property int $organization_id
 * @property int $user_id
 * @property $birthdate
 * @property string|null $icon_link
 * @property $about
 *
 * @property User $user
 * @property Organization $organization
 * @property PeoplePosition[] $peoplePositions
 * */
class People extends Model
{
    protected $table = 'people';
    protected $fillable = [
        'firstname',
        'surname',
        'patronymic',
        'phone_number',
        'organization_id',
        'user_id',
        'birthdate',
        'icon_link',
        'about'
    ];
    protected $hidden = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    public function peoplePositions()
    {
        return $this->hasMany(PeoplePosition::class);
    }
    public function getPosition(){
        $positions = $this->peoplePositions->filter(function($peoplePosition){
            return $peoplePosition->is_active == true;
        });
        if ($positions->isNotEmpty()) {
            return $positions->first()->position->name;
        }
        return null;
    }
    public function getBranchName()
    {
        $positions = $this->peoplePositions->filter(function($peoplePosition){
            return $peoplePosition->is_active == true;
        });
        if ($positions->isNotEmpty()) {
            return $positions->first()->branch->name;
        }
        return null;
    }
    public function getEducation()
    {
        $data = json_decode($this->about);
        return $data->education;
    }
    public function getBio()
    {
        $data = json_decode($this->about);
        return $data->bio;
    }
    public function getWorkExperience()
    {
        $data = json_decode($this->about);
        return $data->workExperience;
    }
    public function getSkills()
    {
        $data = json_decode($this->about);
        return $data->skills;
    }
    public function getFullFio(){
        return $this->surname . ' ' . $this->firstname . ' ' . $this->patronymic;
    }
}
