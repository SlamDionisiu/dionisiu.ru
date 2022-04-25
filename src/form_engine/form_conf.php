<?php
global $FORM_CONFIG;
$FORM_CONFIG = array(
    array(
        'type'                  => 'text',
        'name'                  => 'fioInput',
        'label'                 => 'Ф.И.О',
        'placeholder'           => 'К примеру: Иванов Иван Иванович',
        'required'              => true,
    ),

    array(
        'type'                  => 'tel',
        'name'                  => 'telInput',
        'label'                 => 'Контактный номер телефона',
        'placeholder'           => '+375 ()',
        'tip'                 => '9 цифр в формате код( _ _ ) телефон ( _ _ _ _ _ _ _)',
        'required'              => true,
    ),

    array(
        'type'                  => 'email',
        'name'                  => 'emailInput',
        'label'                 => 'Email',
        'placeholder'           => 'exzample@gmail.com',
        'required'              => true,
    ),

    array(
        'type'                  => 'select',
        'name'                  => 'selectInput',
        'multiple'              => true,
        'wrapClass'             => 'form-group',
        'label'                 => 'Выберите должность',
        'required'              => true,
        'values'                => array(
            'Системный администратор',
            'Программист PHP',
            'Веб дизайнер',
            'Контент менеджер',
            'SEO специалист',
        ),
    ),

    array(
        'type'                  => 'textarea',
        'name'                  => 'textInput',
        'wrapClass'             => 'form-group',
        'label'                 => 'Напишите о себе:',
        'required'              => false,
    ),

    array(
        'name'                  => 'fileInput',
        'type'                  => 'file',
        'label'                 => 'Файлы резюме',
        'uploadDir'             => 'upload/',
        'required'              => true,
        'fileTypes'             => array(
            'application/octet-stream',
            'application/pdf',
        ),
        'multiple'              => true,
        'tip'                 => "файл размером до 5мб .doc и .pdf типов",
        'fileSize'              => 50000000,
    ),
);