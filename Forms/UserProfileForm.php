<?php

namespace OfficeGuru\Forms;

use OfficeGuru\Repositories\UserRepository;

class UserProfileForm extends Form
{
    /** @var int */
    const IMAGE_MAX_FILESIZE = 5242800; // 5Mb
    const IMAGE_VALID_TYPES = ['image/gif', 'image/jpeg', 'image/png'];

    /** @var string */
    private $email;
    /** @var string */
    private $firsName;
    /** @var string */
    private $lastName;
    /** @var string */
    private $image;
    /** @var array */
    private $newImage;


    public function __construct($post, $files)
    {
        parent::__construct();

        $this->email = $post['email'] ?? '';
        $this->firsName = $post['first_name'] ?? '';
        $this->lastName = $post['last_name'] ?? '';
        $this->image = $post['image'] ?? '';
        $this->newImage = $files['new_image'] ?? [];
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        $myUserRepo = new UserRepository;

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
        {
            $this->addMessage(array('email' => 'Debe ingresar un email válido'));
        } 

        if(trim($this->firsName) == '')
        {
            $this->addMessage(array('first_name' => 'Debe ingresar un nombre'));
        }

        if(trim($this->lastName) == '')
        {
            $this->addMessage(array('last_name' => 'Debe ingresar un apellido'));
        }

        if (isset($this->newImage) && $this->newImage['size'] !== 0)
        {
            $imagePath = $this->newImage['tmp_name'];
            if (file_exists($imagePath))
            {
                $imageSizeData = getimagesize($imagePath);
                if (!$imageSizeData || !in_array($imageSizeData['mime'], self::IMAGE_VALID_TYPES))
                {
                    $this->addMessage(array('image' => 'El archivo no es un tipo de imágen válida. Se aceptan los formato JPG, GIF y PNG'));
                }
                elseif ($this->newImage['size'] > self::IMAGE_MAX_FILESIZE) {
                    $this->addMessage(array('image' => 'El archivo no puede ser mayor a 5Mb'));
                }
            }
            else
            {
                $this->addMessage(array('image' => 'Ha ocurrido un error al subir la imagen'));
            }
        }

        return empty($this->getMessages());
    }

}