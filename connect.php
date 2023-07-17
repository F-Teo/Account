<?php
function connectDb(): PDO
{
    return new PDO('mysql:host=localhost;dbname=ntest;', 'root', '');
}