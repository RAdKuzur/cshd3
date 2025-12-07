<?php

namespace App\Services;

use App\Models\Auditorium;
use App\Repositories\AuditoriumRepository;

class AuditoriumService
{
    public AuditoriumRepository $auditoriumRepository;
    public function __construct(
        AuditoriumRepository $auditoriumRepository
    )
    {
        $this->auditoriumRepository = $auditoriumRepository;
    }

    public function index()
    {
        $data = [];
        $auditoriums = $this->auditoriumRepository->getAll();
        foreach ($auditoriums as $auditorium) {
            $data[] = [
                'id' => $auditorium->id,
                'name' => $auditorium->name,
                'floor' => $auditorium->floor,
                'number' => $auditorium->number,
                'department_id' => $auditorium->department_id,
                'branch_id' => $auditorium->branch_id,
                'comment' => $auditorium->comment,
            ];
        }
        return $data;
    }
    public function map(){
        $data = [];
        $auditoriums = $this->auditoriumRepository->getAll();
        foreach ($auditoriums as $auditorium) {
            $things = [];
            $employees = [];
            foreach ($auditorium->things as $thing) {
                $things[] = [
                    'id' => $thing->id,
                    'name' => $thing->name,
                    'inv_number' => $thing->inv_number,
                    'thing_type_id' => $thing->thing_type_id,
                    'condition' => $thing->condition,
                    'serial_number' => $thing->serial_number,
                    'balance' => $thing->balance
                ];
            }
            foreach($auditorium->people as $person){
                $employees[] = [
                    'fio' => $person->getFullFio(),
                    'position' => $person->getPosition(),
                ];
            }
            $data[] = [
                'auditorium_id' => $auditorium->id,
                'auditorium_name' => $auditorium->name,
                'comment' => $auditorium->comment,
                'floor' => $auditorium->floor,
                'branch_id' => $auditorium->branch_id,
                'things' => $things,
                'employees' => $employees
            ];
        }
        return $data;
    }
    public function create($data){
        $this->auditoriumRepository->create($data);
    }
    public function update($id, $data){
        $this->auditoriumRepository->update($id, $data);
    }
    public function delete($id){
        $this->auditoriumRepository->delete($id);
    }
}
