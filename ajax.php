<?php

/*

This file is a boostrap for all ajax requests.

*/

if(is_callable($_GET['section'])) call_user_func($_GET['section']);