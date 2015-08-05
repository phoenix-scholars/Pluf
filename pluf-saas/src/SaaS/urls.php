<?php
return array(
        array( // اطلاعات نرم‌افزار مورد نظر
                'regex' => '#^/app/(\d+)$#',
                'model' => 'SaaS_Views_Application',
                'method' => 'get',
                'http-method' => 'GET',
                'saas' => array(
                        'match-application' => 1
                )
        ),
        array( // اطلاعات نرم‌افزار مورد نظر
                'regex' => '#^/app/(\d+)$#',
                'model' => 'SaaS_Views_Application',
                'method' => 'update',
                'http-method' => 'POST',
                'saas' => array(
                        'match-application' => 1
                )
        ),
        array( // فهرستی از تمام نرم‌افزارهای موجود
                'regex' => '#^/app/list$#',
                'model' => 'SaaS_Views_Application',
                'method' => 'applications'
        ),
        /* دسترسی‌ها به نرم‌افزار */
        array( // اطلاعات نرم‌افزار جاری
                'regex' => '#^/app$#',
                'model' => 'SaaS_Views_Application',
                'method' => 'currentApplication',
                'http-method' => 'GET'
        ),
        array( // ایجاد یک نرم‌افزار جدید
                'regex' => '#^/app$#',
                'model' => 'SaaS_Views_Application',
                'method' => 'create',
                'http-method' => 'POST'
        ),
        array( // فهرستی از تمام اعضا
                'regex' => '#^/app/(\d+)/member/list$#',
                'model' => 'SaaS_Views_Application',
                'method' => 'members',
                'saas' => array(
                        'match-application' => 1
                )
        ),
        /* تنظیم‌ها */
        array( // فهرستی از تنظیم‌ها
                'regex' => '#^/app/(\d+)/config/list$#',
                'model' => 'SaaS_Views_Configuration',
                'method' => 'configurations',
                'http-method' => 'GET',
                'saas' => array(
                        'match-application' => 1
                )
        ),
        array( // دسترسی به تنظیم‌ها با شناسه
                'regex' => '#^/app/(\d+)/config/(\d+)$#',
                'model' => 'SaaS_Views_Configuration',
                'method' => 'get',
                'http-method' => 'GET',
                'saas' => array(
                        'match-application' => 1
                ),
                'freemium' => array(
                        'level' => Pluf::f('saas_freemium_full', 5)
                )
        ),
        array( // دسترسی به تنظیم‌ها با نام
                'regex' => '#^/app/(\d+)/configByName/(.+)$#',
                'model' => 'SaaS_Views_Configuration',
                'method' => 'getByName',
                'http-method' => 'GET',
                'saas' => array(
                        'match-application' => 1
                )
        ),
        array( // ایجاد یک تنظیم جدید
                'regex' => '#^/app/(\d+)/config/create$#',
                'model' => 'SaaS_Views_Configuration',
                'method' => 'create',
                'http-method' => 'POST',
                'saas' => array(
                        'match-application' => 1
                ),
                'freemium' => array(
                        'level' => Pluf::f('saas_freemium_full', 5)
                )
        )
);