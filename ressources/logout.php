<?php
/**
 * Created by IntelliJ IDEA.
 * User: caylak
 * Date: 13.12.2018
 * Time: 14:52
 */

session_start();
session_destroy();
echo 'You have been logged out. <a href="/">Go back</a>';