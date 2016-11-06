<?php
Pluf::loadFunction('Pluf_Shortcuts_GetObjectOr404');
Pluf::loadFunction('SaaS_Shortcuts_GetSPAOr404');
Pluf::loadFunction('SaaS_Shortcuts_GetApplicationOr404');

/**
 * کار با برنامه‌های کاربردی برای نمایش
 *
 * یکی از مهم‌ترین ساختارهای داده‌ای، ساختارهایی است که برای توصیف نرم‌افزارهای
 * کاربردی به کار برده می‌شود. این نمایش تمام راهکارهای مورد نیاز برای کار با این
 * ساختار داده‌ای را در سیستم فراهم کرده است.
 *
 * در این کلاس ابزارهایی برای لود کردن برنامه‌های کاربردی در نظر گرفته شده است. به
 * عنوان نمونه اگر کاربر بخواهد برنامه کاربردی پیش فرض برای یک ملک را اجرا کند
 * در این کلاس برای آن فراخوانی در نظر گرفته شده است.
 *
 * اکثر فراخوانی‌هایی که در این لایه نمایش ایجاد شده در پرونده urls-app2.php به کار
 * گرفته شده است.
 *
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *        
 */
class SaaS_Views_SPA
{

    /**
     * جستجوی نرم‌افزارهای کاربردی
     *
     * این فراخوانی برای جستجو تمام نرم افزارهای کاربردی موجود در سیستم به کار گرفته
     * می‌شود. این فراخوانی برای استفاده تمام کاربران آزاد است و کاربران می‌توانند از
     * بین تمام نرم افزارهای موجود نرم افزارهای مورد نظر خود را پیدا کنند.
     *
     * @param unknown $request            
     * @param unknown $match            
     */
    public static function find($request, $match)
    {
        $pag = new Pluf_Paginator(new SaaS_SPA());
        $list_display = array(
            'id' => 'spa id',
            'title' => 'title',
            'creation_dtime' => 'creation time'
        );
        $search_fields = array(
            'name',
            'title',
            'description',
            'homepage'
        );
        $sort_fields = array(
            'id',
            'name',
            'title',
            'homepage',
            'license',
            'version',
            'creation_dtime'
        );
        $pag->configure($list_display, $search_fields, $sort_fields);
        $pag->action = array();
        $pag->items_per_page = SaaS_Shortcuts_GetItemListCount($request);
        $pag->sort_order = array(
            'creation_dtime',
            'DESC'
        );
        $pag->setFromRequest($request);
        return new Pluf_HTTP_Response_Json($pag->render_object());
    }

    /**
     * اطلاعات یک spa
     *
     * این فراخوانی اطلاعات یک spa را در اختیار کاربران قرار می‌دهد. در حالت عادی دسترسی به
     * اطلاعات نرم‌افزارها به دسترسی‌های خاصی نیاز ندارد و هر کاربری قادر است که به آنها دسترسی
     * داشته باشد.
     *
     * @param unknown $request            
     * @param unknown $match            
     */
    public static function get($request, $match)
    {
        $spa = SaaS_Shortcuts_GetSPAOr404($match[1]);
        return new Pluf_HTTP_Response_Json($spa);
    }

    /**
     * یک نرم افزار جدید را در سیستم ایجاد میکند.
     *
     * این فراخوانی موظف است که یک نرم افزار جدید در سیستم ایجاد کند.
     *
     * @note در حال حاضر این امکان فراهم نشده و نرم فزارها باید به صورت دستی ایجاد شوند.
     *
     * @param unknown $request            
     * @param unknown $match            
     */
    public static function create($request, $match)
    {}

    /**
     * اطلاعات یک نرم افزار را به روز می‌کند.
     *
     * اطلاعاتی که از نرم افزار در پایگاه داده نگهداری می‌شود بر اساس اطلاعاتی که در خود نرم افزار
     * وجود دارد به روز خواهد شد.
     *
     * @param unknown $request            
     * @param unknown $match            
     */
    public static function refresh($request, $match)
    {
        $spa = SaaS_Shortcuts_GetSPAOr404($match[1]);
        // TODO: maso, 1395: به روز کردن بسته
        return new Pluf_HTTP_Response_Json($spa);
    }

    /**
     * به روز کردن تمام نرم‌افزارها
     *
     * تمام نرم افزارهایی که در سیستم نصب شده است را به روز رسانی می‌کند.
     *
     * @param unknown $request            
     * @param unknown $match            
     */
    public static function refreshAll($request, $match)
    {
        SaaS_Migrations_Update_spa();
        // XXX: maso, 1395: مدل کلی انجام پردازش‌های سرور نیز تعیین شود.
        return new Pluf_HTTP_Response_Json(array(
            'id' => '0',
            'progress' => array(
                'title' => 'updating spas',
                'totalWork' => 1,
                'done' => true
            )
        ));
    }

    /**
     * اطلاعات پیاده سازی بسته را تعیین می‌کند
     *
     * هر نرم افزار بر اساس یک پرونده spa.json ایجاد می‌شود. این فراخوانی امکان دسترسی به
     * محتوی spa.json را برای کاربران فراهم می‌کند.
     *
     * @param unknown $request            
     * @param unknown $match            
     */
    public static function package($request, $match)
    {
        $spa = SaaS_Shortcuts_GetSPAOr404($match[1]);
        $package = $spa->loadConfig();
        return new Pluf_HTTP_Response_Json($package);
    }

    /**
     * **************************************************************************************
     * XXX: Hadi, 1395: متدهای این قمست باید بررسی شوند
     */
    /**
     * Loads SPA (by name) or resource (by name).
     * First search for SPA with specified name.
     * If such SPA is not found search for resource file with specified name in default SPA of tenant.
     *
     * @param unknown $request            
     * @param array $match            
     * @return Pluf_HTTP_Response_File|Pluf_HTTP_Response
     */
    public static function loadSpaOrResource($request, $match)
    {
        $tenant = $request->tenant;
        $path = $match['path'];
        if (! isset($path)) {
            throw new Pluf_Exception('Name for spa or resource is null!');
        }
        $spa = SaaS_SPA::getSpaByName($path);
        $resource = null;
        if (! isset($spa)) {
            $spa = $tenant->get_spa();
            $resource = $path;
        }
        return SaaS_Views_SPA::loadSpaResource($request, $tenant, $spa, $resource);
        // // TODO: Check access
        // SaaS_Precondition::userCanAccessApplication($request, $tenant);
        // // SaaS_Precondition::userCanAccessSpa($request, $spa);
        
        // // نمایش اصلی
        // return SaaS_Views_SPA::loadSpa($request, $tenant, $spa);
    }

    public static function loadDefaultSpa($request, $match)
    {
        $tenant = $request->tenant;
        return SaaS_Views_SPA::loadSpaResource($request, $tenant);
        // $spa = $tenant->get_spa();
        
        // // TODO: Check access
        // SaaS_Precondition::userCanAccessApplication($request, $tenant);
        // // SaaS_Precondition::userCanAccessSpa($request, $spa);
        
        // // Load spa
        // return SaaS_Views_SPA::loadSpa($request, $tenant, $spa);
    }

    public static function getResource($request, $match)
    {
        // Load data
        $resourcePath = $match['resource'];
        $tenant = $request->tenant;
        if ($match['spa']) {
            $spa = SaaS_SPA::getSpaByName($match['spa']);
        }
        if (! isset($spa)) {
            $spa = $tenant->get_spa();
            $resourcePath = $match[0];
        }
        return SaaS_Views_SPA::loadSpaResource($request, $tenant, $spa, $resourcePath);
        // // TODO: Check access
        // $resPath = $spa->getResourcePath($resourcePath);
        // if (! $resPath) {
        // // Try to load resource form assets directory of platform
        // $resPath = SaaS_SPA::getAssetsPath($resourcePath);
        // }
        // return new Pluf_HTTP_Response_File($resPath, SaaS_FileUtil::getMimeType($resPath));
    }

    public static function getResourceOfDefault($request, $match)
    {
        // Load data
        $tenant = $request->tenant;
        $spa = $tenant->get_spa();
        
        return SaaS_Views_SPA::loadSpaResource($request, $tenant, $spa, $match['resource']);
        // // TODO: Check access
        // // Load resource form local resources of spa
        // $res = $spa->getResourcePath($match['resource']);
        // if (! $res) {
        // // Try to load resource form assets directory of platform
        // $res = SaaS_SPA::getAssetsPath($match['resource']);
        // }
        // return new Pluf_HTTP_Response_File($res, SaaS_FileUtil::getMimeType($res));
    }

    protected static function loadSpa($request, $app, $spa)
    {
        // در صورتی که درخواست مربوط به seo باشد
        if (array_key_exists('_escaped_fragment_', $request->GET)) {
            return SaaS_Shortcuts_SeoResponse($request, $spa);
        }
        
        // نمایش اصلی
        $mainPage = $spa->getMainPagePath();
        
        return new Pluf_HTTP_Response_File($mainPage, SaaS_FileUtil::getMimeType($mainPage));
    }

    /**
     * Loads a resource from an SPA of a tenant.
     * Tenant could not be null.
     * If $spa is null default SPA of tenant is used. If $resource is null default main page of
     * SPA is used.
     *
     * @param unknown $request            
     * @param SaaS_Application $tenant            
     * @param SaaS_SPA $spa            
     * @param string $resource            
     * @throws Pluf_EXception if tenant is null or spa could not be found.
     * @return Pluf_HTTP_Response_File|Pluf_HTTP_Response|Pluf_HTTP_Response_File
     */
    protected static function loadSpaResource($request, $tenant, $spa = null, $resource = null)
    {
        // Tenant
        if (! isset($tenant)) {
            throw new Pluf_EXception('Tenant is not set determined!');
        }
        // SPA
        if (! isset($spa)) {
            // Default spa of tenant
            $_spa = $tenant->get_spa();
            if (! isset($_spa)) {
                throw new Pluf_Exception('Spa could not be found!');
            }
        } else {
            $_spa = $spa;
        }
        // Resource
        if (! isset($resource)) {
            return SaaS_Views_SPA::loadSpa($request, $tenant, $_spa);
        }
        // TODO: Check access
        $resPath = $_spa->getResourcePath($resource);
        if (! $resPath) {
            // Try to load resource form assets directory of platform
            $resPath = SaaS_SPA::getAssetsPath($resource);
        }
        return new Pluf_HTTP_Response_File($resPath, SaaS_FileUtil::getMimeType($resPath));
    }
}