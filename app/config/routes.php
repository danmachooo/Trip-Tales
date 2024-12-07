<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

$router->get('/', 'Auth');
$router->get('/home', 'Entry_controller::get_all_entries');
$router->group('/auth', function() use ($router){
    $router->match('/register', 'Auth::register', ['POST', 'GET']);
    $router->match('/login', 'Auth::login', ['POST', 'GET']);
    $router->get('/logout', 'Auth::logout');
    $router->match('/password-reset', 'Auth::password_reset', ['POST', 'GET']);
    $router->match('/set-new-password', 'Auth::set_new_password', ['POST', 'GET']);
});

$router->group('/posts', function() use ($router) {
    $router->match('/save-entry', 'Entry_controller::save_entry', ['POST', 'GET']);
    $router->post('/toggle_like', 'Entry_controller::toggle_like');
    $router->post('/add_comment', 'Entry_controller::add_comment');
    $router->get('/get_comments', 'Entry_controller::get_comments');
});



$router->get('/chat', 'Chat_controller::index');
$router->post('/chat/send-message', 'Chat_controller::send_message');
$router->get('/chat/get-messages', 'Chat_controller::get_messages');
$router->get('/chat/{receiver_id}', 'Chat_controller::get_recepient');
$router->post('/chat/{receiver_id}', 'Chat_controller::get_recepient');


$router->get('/Admin/admin_dashboard', 'Admin::admin_dashboard');
$router->get('/Admin/admin_activity', 'Admin::admin_activity');      
$router->get('/Admin/admin_users', 'Admin::admin_users');   
$router->get('/Admin/admin_notification', 'Admin::admin_notification');   
$router->get('/Admin/admin_setting', 'Admin::admin_setting');   

$router->get('/profile', 'Home::profile'); 
