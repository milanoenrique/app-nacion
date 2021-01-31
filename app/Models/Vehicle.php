<?php

namespace Model;

class Vehicle{

  public $name;
  public $model;
  public $manufacturer;
  public $cost_in_credits;
  public $length;
  public $max_atmosphering_speed;
  public $crew;
  public $passengers;
  public $cargo_capacity;
  public $consumables;
  public $vehicle_class;
  public $pilots;
  public $films;
  protected $created;
  protected $edited;
  protected $url;

  public function __construct($name, $model, $manufacturer, $cost_in_credits, $length, $max_atmosphering_speed, $crew, $passengers, $cargo_capacity, $consumables, $vehicle_class, $pilots, $films, $created,$edited, $url)
  {
    $this->name = $name ;
    $this->model = $model;
    $this->manufacturer = $manufacturer;
    $this->cost_in_credits = $cost_in_credits;
    $this->length = $length;
    $this->max_atmosphering_speed = $max_atmosphering_speed;
    $this->crew = $crew;
    $this->passengers = $passengers;
    $this->cargo_capacity = $cargo_capacity;
    $this->consumables = $consumables;
    $this->vehicle_class = $vehicle_class;
    $this->pilots = $pilots;
    $this->films = $films;
    $this->$created = $created;
    $this->$edited = $edited;
    $this->url = $url;

  }

}
