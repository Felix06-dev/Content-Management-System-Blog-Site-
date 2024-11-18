<?php

$connect = mysqli_connect('localhost', 'cms', 'Password123', 'cms');

if (mysqli_connect_errno())
{
	exit('Failed to connect to MySQL; ' . mysqli_connect_error());
}