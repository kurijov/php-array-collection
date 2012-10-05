<?php

class myIterator implements Iterator {
    private $position = 0;

    public function __construct() {
      $this->position = 0;
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->_data[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->_data[$this->position]);
    }
}

/**
 * @author kurijov
 * array utility 
 * allows to make selections, add, remove elements
 */
class ArrayCollection extends myIterator
{
  public function __construct($data = array())
  {
    $this->reset($data);
  }

  public function reset($data = array())
  {
    $this->_data = $data;
    return $this;
  }

  public function add($newValue)
  {
    $this->_data[] = $newValue;
    return $this;
  }

  public function remove($value)
  {
    if ($value instanceof ArrayCollection) {
      foreach ($value as $item) {
        $this->remove($item);
      }
    } else {
      $key = array_search($value, $this->data());
      if ($key !== false) {
        unset($this->_data[$key]);
      }
    }
    return $this;
  }

  public function where($pattern)
  {
    $out = array();
    foreach ($this->data() as $value) {

      $matches = true;
      foreach ($pattern as $patternKey => $patternValue) {
         $matches = $matches && ($value->$patternKey == $patternValue);
      } 
      if ($matches) {
        $out[] = $value;
      }
    }

    return new ArrayCollection($out);
  }

  public function id($id)
  {
    return $this->first(array("id" => $id));
  }

  public function first($pattern = false)
  {
    if ($pattern) {
      $result = $this->_first($this->where($pattern));
    } else {
      $result = $this->_first($this->_data);
    }

    return $result;
  }

  private function _first($data = array())
  {
    $data   = $this->toArray($data);
    $length = count($data);
    if ($length) {
      return array_shift(array_values($data));
    } else {
      return false;
    }
  }

  public function data()
  {
    return $this->_data;
  }

  protected function toArray($array)
  {
    if ($array instanceof ArrayCollection) {
      return $array->data();
    }

    return $array;
  }
}