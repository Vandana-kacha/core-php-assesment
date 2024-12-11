<?php

class Json
{ 
    private $jsonFile = "json_files/data.json";
    private $userFile = "json_files/user.json";

    public function getUser($pass)
    { 
        if(file_exists($this->jsonFile)) { 
            $jsonData = file_get_contents($this->userFile);
            $data = json_decode($jsonData, true);

            if(!empty($data))
            {
                $password = $data['0']['password'];
                if ($pass == $password) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    } 

    public function changePassword($oldpass, $newpass)
    { 
        if(!empty($oldpass) && !empty($newpass)) { 
            $jsonData = file_get_contents($this->userFile);
            $data = json_decode($jsonData, true); 
            foreach ($data as $key => $value) { 
                if ($value['password'] == $oldpass) {
                    $data[$key]['password'] = $newpass; 
                    $update = file_put_contents($this->userFile, json_encode($data)); 
                }
            }
            return $update ? true : false;
        } else { 
            return false;
        } 
    }
    
    public function getRows()
    { 
        if(file_exists($this->jsonFile)) {
            $jsonData = file_get_contents($this->jsonFile);
            $data = json_decode($jsonData, true);
            
            if(!empty($data)) { 
                usort($data, function($a, $b) { 
                    return $b['id'] - $a['id'];
                });
            }
            
            return !empty($data) ? $data : false;
        } 
        return false;
    }

    public function getResult($data)
    {
        $jsonData = file_get_contents($this->jsonFile);
        $jsonval = json_decode($jsonData, true);

        $mystring = $data;
        $Found = false;
        $findme = $jsonval;

        if(array_search($mystring, array_column($jsonval, 'book_name')) !== false) { 
            $singleData = array_filter($jsonval, function ($var) use ($mystring) { 
                return (!empty($var['book_name']) && $var['book_name'] == $mystring); 
            });
            $singleData = array_values($singleData);
        } else if(array_search($mystring, array_column($jsonval, 'book_id')) !== false) { 
            $singleData = array_filter($jsonval, function ($var) use ($mystring) { 
                return (!empty($var['book_id']) && $var['book_id'] == $mystring); 
            });
            $singleData = array_values($singleData);
        } else {
            $singleData = array();
        }

        return !empty($singleData) ? $singleData : false;
    }
    
    public function getSingle($id)
    { 
        $jsonData = file_get_contents($this->jsonFile);
        $data = json_decode($jsonData, true);
        $singleData = array_filter($data, function ($var) use ($id) {
            return (!empty($var['id']) && $var['id'] == $id);
        });
        $singleData = array_values($singleData)[0];
        return !empty($singleData) ? $singleData : false;
    }
    
    public function insert($newData)
    {
        if(!empty($newData)) {
            $id = time();
            $newData['id'] = $id;
            
            $jsonData = file_get_contents($this->jsonFile);
            $data = json_decode($jsonData, true);
            
            $data = !empty($data) ? array_filter($data) : $data;
            if(!empty($data)) {
                array_push($data, $newData);
            } else {
                $data[] = $newData;
            }
            $insert = file_put_contents($this->jsonFile, json_encode($data));
            
            return $insert ? $id : false;
        } else { 
            return false;
        }
    }
    
    public function update($upData, $id)
    { 
        if(!empty($upData) && is_array($upData) && !empty($id)) { 
            $jsonData = file_get_contents($this->jsonFile);
            $data = json_decode($jsonData, true);
            
            foreach ($data as $key => $value) { 
                if ($value['id'] == $id) { 
                    if(isset($upData['category'])) { 
                        $data[$key]['category'] = $upData['category'];
                    }
                    if(isset($upData['book_id'])) { 
                        $data[$key]['book_id'] = $upData['book_id'];
                    }
                    if(isset($upData['book_name'])) { 
                        $data[$key]['book_name'] = $upData['book_name'];
                    }
                    if(isset($upData['author'])) { 
                        $data[$key]['author'] = $upData['author'];
                    }
                    if(isset($upData['qty'])) { 
                        $data[$key]['qty'] = $upData['qty'];
                    }
                    if(isset($upData['price'])) { 
                        $data[$key]['price'] = $upData['price'];
                    }
                }
            }
            $update = file_put_contents($this->jsonFile, json_encode($data));
            
            return $update ? true : false;
        } else { 
            return false;
        } 
    } 
    
    public function delete($id)
    { 
        $jsonData = file_get_contents($this->jsonFile); 
        $data = json_decode($jsonData, true); 
             
        $newData = array_filter($data, function ($var) use ($id) { 
            return ($var['id'] != $id); 
        }); 
        $delete = file_put_contents($this->jsonFile, json_encode($newData)); 
        return $delete ? true : false; 
    }

}
