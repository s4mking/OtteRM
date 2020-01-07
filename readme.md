# Otterm

Oterm is a homemade ORM with a lot of features

##Installation

You just have to clone this repository, do not forget to install composer. (The **doc** is available [here](https://getcomposer.org/))  
and to run the command
>composer install  

You'll need to create yourconfig.yml file, and within it,
 put the following line :   
>  
>db:
>> name: "dbname"  
>> user: "user"  
>> password: "yourpassword"  
>> host: 127.0.0.1 or anything else  
>> port: 8889 or anything else  
>> driver: 'pdo_mysql'  
>> charset: 'utf8'  
>> logs: 'src/Logs/' or any other folder inside your project  
>
>

This file should be put in the config folder. 

## Usage

All the ORM Config is inside src folder. You don't have to modify anyhting for basic use.
Otterm works like Doctrine it uses entities inside the Examples/Entity folders to find the object definition and mapping your object with the rights SQL fields.
We use the annotations to define the relation SQL/Object.
All your entites must have this fields :
1. At which table this entity refer
```php
     /**
    * Class Film
     * @Table(name="films")
    */
```
2. Relation column to field and which type
```php
    /**
     * @Column(column="id_film")
     * @Type(type="int")
     */
```

To know how to use it inside your projects go to see inside the DataExample folder.

## License
MIT License

Copyright (c) [2020] [Otterm]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.