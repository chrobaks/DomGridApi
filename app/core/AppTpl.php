<?php

use JetBrains\PhpStorm\Pure;

class AppTpl
{
    public static function route (Array $route): string
    {
        $path = [];

        if (is_array($route) && ! empty($route)) {
            foreach($route as $arg) {
                $path[] = (!is_numeric($arg)) ?  urlencode($arg) : $arg;
            }
        }

        return AppRoute::getRoute($path);
    }
    public static function alert (String $txt, String $type, String $icon = "fa fa-exclamation-triangle"): string
    {
        return '<div class="alert '.$type.'" role="alert"><i class="'.$icon.'"></i> '.$txt.'</div>';
    }

    public static function renderServiceRouteJs (String $service): string
    {
        if (isset($_SESSION['sessReLogin']) && (int)$_SESSION['sessReLogin'] === 1) {
            $result = ' data-relogin="'.AppRoute::getRoute(['home', "relogin"]).'"';
        } else {
            $result = (!empty($service)) ? 'data-service-js="'.JS_URL.'/app/service/'.$service.'.service.js?'.date('dmYHis').'"' : '';
        }

        return $result;
    }

    public static function renderAppJs (Array $jsFilesConf): string
    {
        $scripts = [];
        $date = date('d:m:YH:i:s');
        
        foreach ($jsFilesConf as $conf) {

            $requiredFirst = (isset($conf["requiredFirst"])) ? $conf["requiredFirst"] : [];
            $arrFiles = explode(',',$conf["url"].implode(','.$conf["url"], $conf["dir"]));

            if (!empty($arrFiles)) {

                foreach ($arrFiles as $file) {

                    $path = explode('/', $file);

                    if (!empty($requiredFirst) && in_array($path[(count($path)-1)], $requiredFirst)) {
                        if (preg_match('/\.js$/', $file)) {$scripts[] = '<script src="'.$file.'?'.$date.'>"></script>';}
                    }
                }
                
                foreach ($arrFiles as $file) {

                    $path = explode('/', $file);

                    if (preg_match('/\.js$/', $file) && !in_array($path[(count($path)-1)], $requiredFirst)) {
                        $scripts[] = '<script src="'.$file.'?'.$date.'>"></script>';
                    }
                }
            }
        }
        
        if (!empty($scripts)) { $scripts = implode("\n", $scripts)."\n"; }

        return (!empty($scripts)) ? $scripts : '';
    }

    public static function renderAppCss ($arrCss): string
    {
        $links = [];
        $pathCssApp = AppRoute::getRoute('').CSS_URL;
        $date = date('d:m:Y H:i:s');

        if (!empty($arrCss)) {
            foreach ($arrCss as $css) {
                $links[] = '<link href="'.$pathCssApp.$css.'.css?'.$date.'" rel="stylesheet">';
            }
        }

        if (!empty($links)) { $links = implode("\n", $links)."\n";  }

        return (!empty($links)) ? $links : '';
    }

    public static function renderTpl ($path, $view = []): void
    {
        include $path;
    }

    public static function renderLangForm ($activeLang = ""): array
    {
        $languages = AppLang::getLangSelection();
        $result = [];

        if(!empty($languages)) {
            $languages = explode(',', $languages);
            if (!empty($languages)) {
                foreach ($languages as $lang) {
                    $css = ($activeLang === $lang) ? 'class="lang active"' : 'class="lang"';
                    $url = AppRoute::getRoute(['request', 'content', 'lang',$lang]);
                    $result[] = '<a '.$css.' data-request-url="'.$url.'">'.$lang.'</a>';
                }
            }
        }

        return $result;
    }
    #[Pure] public static function renderFormElement ($element): string
    {
        $result = "";

        if(!empty($element)) {
            $tag = $element["element"];
            $typ = $element["type"] ?? "";
            $options = $element["option"] ?? "";
            $value = $element["value"] ?? "";
            $name = $element["name"] ?? "";
            $placeholder = $element["placeholder"] ?? "";
            $title = $element["label"] ?? "";
            $id = $element["id"] ?? "";
            $required = $element["required"] ?? false;
            $css = $element["css"] ?? "";
            $data = $element["data"] ?? "";
            $result = '<';
            $result .= $tag;

            if ($typ !== "") {
                $result .= ' type="'.$typ.'"';
            }
            if ($tag !== 'button' && $tag !== 'select' && $value !== "") {
                $result .= ' value="'.$value.'"';
            }
            if ($name !== "") {
                $result .= ' name="'.$name.'"';
            }
            if ($id !== "") {
                $result .= ' id="'.$id.'"';
            }
            if ($required !== "") {
                $result .= ' data-required="'.$required.'"';
            }
            if ($tag !== 'select' && $placeholder !== "") {
                $result .= ' placeholder="'.$placeholder.'"';
            }
            if ($title !== "") {
                $result .= ' title="'.$title.'"';
            }
            if ($css !== "") {
                $result .= ' class="'.$css.'"';
            }
            if ($data !== "") {
                $result .= ' '.implode(" ", $data);
            }
            $result .= '>';

            if ($tag === 'select') {
                if ($options !== "") {
                    if ($placeholder !== "") {
                        $result .= self::renderFormOption(["value" => "", "text" => $placeholder], 'placeholder');
                    }
                    foreach ($options as $option) {
                        $result .= self::renderFormOption($option, $value);
                    }
                }
                $result .= '</select>';
            }


            if ($tag === 'button') {
                $icon = $element["icon"] ?? "";
                if ($icon) {
                    $icon = '<i class="'.$icon.'"></i>';
                }
                $result .= $icon . $title . '</button>';
            }
        }

        return $result;
    }

    public static function renderFormOption ($element, $selctedValue = ''): string
    {
        $result = "";

        if(!empty($element)) {
            $value = ' value="'.$element["value"].'"' ?? "";
            $text = $element["text"] ?? "";
            $selected = ($selctedValue == $element["value"]) ? ' selected="selected"' : "";

            $result = '<option'.$value . $selected.'>';
            $result .= $text;
            $result .= '</option>';

        }
        return $result;
    }

    public static function renderFormLabel ($element): string
    {
        $result = "";
        $required = $element["required"] ?? false;

        if(!empty($element)) {
            $label = $element["label"] ?? "";
            if ($label !== "") {
                $label = ($required) ? $label. '*' : $label;
                $result = '<label>';
                $result .= $label;
                $result .= '</label>';
            }
        }

        return $result;
    }
    public static function renderInput ($elements): string
    {
        $result = [];
        foreach ($elements as $element) {
            if(!empty($element)) {
                $result[] = self::renderFormElement(array_merge(["element" => "input"], $element));
//                $name = ' name="' . ($element["name"] ?? "") . '"';
//                $value = ' value="' . ($element["value"] ?? "") . '"';
//                $type = ' type="' . ($element["type"] ?? "text") . '"';
//                $input = '<ipnut';
//                $input .= $name;
//                $input .= $value;
//                $input .= $type;
//                $input .= ' >';
//
//                $result[] = $input;
            }
        }

        return implode(' ', $result);
    }

    public static function lang ($key, $lang = "")
    {
        if (empty($lang)) {
            $lang = AppConfig::getConfig('view',['lang_default']);
        }
        return AppLang::getLang($lang, $key);
    }
}