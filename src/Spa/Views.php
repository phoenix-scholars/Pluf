<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
Pluf::loadFunction('Pluf_Shortcuts_GetFormForModel');
Pluf::loadFunction('Pluf_Form_Field_File_moveToUploadFolder');

/**
 * لایه نمایش مدیریت گروه‌ها را به صورت پیش فرض ایجاد می‌کند
 *
 * @author maso
 *        
 */
class Spa_Views extends Pluf_Views
{
    /**
     * یک نر افزار را نصب می‌کند
     *
     * تنها پارامتری که برای نصب نرم افزار لازم است خود فایل نرم افزار هست. سایر
     * اطلاعات از توی فایل برداشته می‌شه. این فایل باید ساختار نرم افزارهای ما
     * رو داشته باشه.
     *
     * @param unknown_type $request            
     * @param unknown_type $match            
     */
    public function create ($request, $match)
    { 
        // XXX: maso, 1395: remove all data on exception
        $tenant = Pluf_Tenant::current();
        // 1- upload & extract
        $path = Pluf::f('upload_path') . '/' . $tenant->id . '/spa/tmp' ;
        Pluf_Form_Field_File_moveToUploadFolder($request->FILES['file'], 
                array(
                        'file_name' => 'spa.zip',
                        'upload_path' => $path,
                        'upload_path_create' => true,
                        'upload_overwrite' => true
                ));
        $zip = new ZipArchive();
        if ($zip->open($path . '/spa.zip') === TRUE) {
            $zip->extractTo($path);
            $zip->close();
        } else {
            throw new Pluf_Exception('Unable to unzip SPA.');
        }
        unlink($path . '/spa.zip');
        
        // 2- load infor
        $filename = $path . '/' . Pluf::f('spa_config', "spa.json");
        $myfile = fopen($filename, "r") or die("Unable to open file!");
        $json = fread($myfile, filesize($filename));
        fclose($myfile);
        $package = json_decode($json, true);
        
        // 3- crate spa
        $spa = new Spa_SPA();
        $spa->path = $path;
        $spa->setFromFormData($package);
        $spa->create();
        
        $spa->path = Pluf::f('upload_path') . '/' . $tenant->id . '/spa/' . $spa->id;
        $spa->update();

        self::rrmdir($spa->path);
        rename($path, $spa->path);
        
        return new Pluf_HTTP_Response_Json($spa);
    }

    /**
     *
     * @param unknown_type $request            
     * @param unknown_type $match            
     */
    public function update ($request, $match)
    {
        $spa = Pluf_Shortcuts_GetObjectOr404('Spa_SPA', $match['spaId']);
        Spa_Views::remdir($spa->path);
        // 1- upload & extract
        Pluf_Form_Field_File_moveToUploadFolder($request->FILES['file'], 
                array(
                        'file_name' => 'spa.zip',
                        'upload_path' => $spa->path,
                        'upload_path_create' => true,
                        'upload_overwrite' => true
                ));
        $zip = new ZipArchive();
        if ($zip->open($spa->path . '/spa.zip') === TRUE) {
            $zip->extractTo($spa->path);
            $zip->close();
        } else {
            throw new Pluf_Exception('fail to extract zip package');
        }
        unlink($spa->path . '/spa.zip');
        
        // 2- load infor
        $filename = $spa->path . '/' . Pluf::f('spa_config', "spa.json");
        $myfile = fopen($filename, "r") or die("Unable to open file!");
        $json = fread($myfile, filesize($filename));
        fclose($myfile);
        $package = json_decode($json, true);
        
        // 3- update spa
        $spa->setFromFormData($package);
        $spa->update();
        
        return new Pluf_HTTP_Response_Json($spa);
    }

    /**
     *
     * @param unknown_type $request            
     * @param unknown_type $match            
     */
    public function delete ($request, $match)
    {
        $spa = Pluf_Shortcuts_GetObjectOr404('Spa_SPA', $match['spaId']);
        Spa_Views::rrmdir($spa->path);
        $spa->delete();
        return new Pluf_HTTP_Response_Json($spa);
    }

    static function rrmdir ($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        Spa_Views::rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    static function remdir ($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        Spa_Views::rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
        }
    }
}