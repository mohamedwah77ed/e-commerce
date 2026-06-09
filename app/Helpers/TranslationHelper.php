<?php

if (!function_exists('trans_lang')) {
    /**
     * Get translation based on current locale
     * 
     * @param string $ar Arabic text
     * @param string $en English text
     * @return string
     */
    function trans_lang(string $ar, string $en): string
    {
        return app()->getLocale() === 'ar' ? $ar : $en;
    }
}

if (!function_exists('trans_dir')) {
    /**
     * Get direction-based value
     * 
     * @param string $rtlValue Value for RTL
     * @param string $ltrValue Value for LTR
     * @return string
     */
    function trans_dir(string $rtlValue, string $ltrValue): string
    {
        return app()->getLocale() === 'ar' ? $rtlValue : $ltrValue;
    }
}

if (!function_exists('is_rtl')) {
    /**
     * Check if current locale is RTL
     * 
     * @return bool
     */
    function is_rtl(): bool
    {
        return app()->getLocale() === 'ar';
    }
}

if (!function_exists('trans_icon')) {
    /**
     * Get FontAwesome icon based on direction
     * 
     * @param string $rtlIcon Icon for RTL
     * @param string $ltrIcon Icon for LTR
     * @return string
     */
    function trans_icon(string $rtlIcon, string $ltrIcon): string
    {
        $icon = app()->getLocale() === 'ar' ? $rtlIcon : $ltrIcon;
        return 'fas ' . $icon;
    }
}
