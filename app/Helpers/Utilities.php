<?php 

use app\Http\ENtoBN;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Display DateTime.
 *
 * Empty check the date first to avoid displaying default date '01 January 1970',
 * then translate the string if applicable, and return the formatted DateTime.
 *
 * @param integer $dateTimeInput DateTime as input.
 * @param string  $format        Date Format.
 *
 * @return string                String translated, EmDash otherwise.
 * -----------------------------------------------------------------------
 */
function displayDateTime($dateTimeInput, $format = 'd F Y')
{
    if (empty($dateTimeInput)) {
        return '―';
    }

    $formattedDate = date($format, strtotime($dateTimeInput));

    if ('bn' == config('app.locale')) {
        return ENtoBN::translate($formattedDate);
    } else {
        return $formattedDate;
    }
}

/**
 * Resolve Field Name.
 *
 * If the data is available in the column of current language, then get from there,
 * otherwise fall back to English column (by default).
 *
 * @param object $object|array  Data object or Array.
 * @param string $column_prefix Column name prefix. Default: 'name_'.
 * @param string $fallback_lang Column langugage follback. Default: 'en'.
 *
 * @return string The available string from the available column.
 */
function resolveFieldName($object, $column_prefix = 'name_', $fallback_lang = 'en')
{
    $lang = config('app.locale');

    $fallback_column = $column_prefix . $fallback_lang;
    $column          = $column_prefix . $lang;


    if (is_object($object)) {
        $column_value = $object->$column ?? $object->$fallback_column;
        if (strlen($column_value) <= 0) {
            $column_value = $object->$fallback_column;
        }
    } elseif (is_array($object)) {
        $column_value = $object[$column] ?? $object[$fallback_column];
        if (strlen($column_value) <= 0) {
            $column_value = $object[$fallback_column];
        }
    }

    return $column_value ?? '-';
}

/**
 * Get all the Months.
 *
 * @return array
 */
function months()
{
    return array(
        1 => __('January'),
        2 => __('February'),
        3 => __('March'),
        4 => __('April'),
        5 => __('May'),
        6 => __('June'),
        7 => __('July'),
        8 => __('August'),
        9 => __('September'),
        10 => __('October'),
        11 => __('November'),
        12 => __('December'),
    );
}

/**
 * Translate String, when applicable.
 *
 * Translate the string only when certain locale is set.
 *
 * @param string $string String to translate.
 *
 * @return string        Translated/Non-translated string.
 * -----------------------------------------------------------------------
 */
function translateString($string)
{
    $translatedString = ('bn' == config('app.locale')) ? ENtoBN::translate($string) : $string;

    return $translatedString;
}

function translateAlphabet($string)
{
    $translatedString = ('bn' == config('app.locale')) ? ENtoBN::translateAlphabetToConsonent($string) : $string;

    return $translatedString;
}

function translateNumberInWords($number)
{
    if (is_numeric($number)) {
        if (($number < 0) || ($number > 999999999)) {
            $res = "Number is out of range";
            $translatedString = $number;
        }else{
            $translatedString =  ENtoBN::translateNumberToBengaliWords($number, config('app.locale'));
        }
    } else {
        $translatedString = $number;
    }

    return $translatedString;
}

/**
 * Items Per Page (IPP).
 *
 * Restrict items per page within the defined item limits.
 *
 * @param  integer $default Default is 10 items per page.
 * @return integer Fool-proof items per page.
 */
function itemsPerPage($default = 10)
{
    $itemLimits = config('app.items_per_pages');

    $itemsPerPage = Request::input('ipp') ?? $default;

    if (!in_array($itemsPerPage, $itemLimits)) {
        $itemsPerPage = $default;
    }

    return $itemsPerPage;
}


/**
 * Show the Footer of a Grid/List.
 *
 * @param object  $query        Query object.
 * @param integer $itemsPerPage Items per page count.
 */
function gridFooter($query, $itemsPerPage)
{
    $itemLimits  = config('app.items_per_pages');
    $query_count = ('bn' === app()->getLocale()) ? ENtoBN::translate_number($query->count()) : $query->count();
    $query_total = ('bn' === app()->getLocale()) ? ENtoBN::translate_number($query->total()) : $query->total();


    ob_start();
?>

    <div class="row small text-muted">
        <div class="col-sm-4 pt-1">
            <?php echo __('Per page'); ?>
            <select name="ipp" id="items-per-page" class="custom-select custom-select-sm w-auto">
                <?php foreach ($itemLimits as $limit) { ?>
                    <option value="<?php echo intval($limit); ?>" <?php echo $itemsPerPage == $limit ? 'selected="selected"' : ''; ?>><?php echo translateString($limit); ?></option>
                <?php } ?>
            </select>
            <?php echo __('items'); ?>
            <span class="ml-1 mr-1">|</span>
            <?php echo __('Showing :count out of :total items', ['count' => $query_count, 'total' => $query_total]); ?>
        </div>
        <div class="col-sm-8 text-sm-right">
            <?php
            if ($query->total() > $itemsPerPage) {
                // Pagination keeping the filter parameters
                echo $query->appends(Request::except('page'))->render();
            } else {
                echo __('Page 1');
            }
            ?>
        </div>
    </div>

<?php
    return ob_get_clean();
}

/**
 * Show the Footer of a Grid/List.
 *
 * @param object  $query        Query object.
 * @param integer $itemsPerPage Items per page count.
 */
function gridFooterSimplePaginate($links, $itemsPerPage, $query_total)
{
    $itemLimits  = config('app.items_per_pages');
    $query_count = 10;
    if (isset($_GET['ipp']) && !empty($_GET['ipp'])) {
        $query_count = $_GET['ipp'];
    }
?>

    <div class="row small text-muted">
        <div class="col-sm-4 pt-1">
            <?php echo __('Per page'); ?>
            <select name="ipp" id="items-per-page" class="custom-select custom-select-sm w-auto">
                <?php foreach ($itemLimits as $limit) { ?>
                    <option value="<?php echo intval($limit); ?>" <?php echo $itemsPerPage == $limit ? 'selected="selected"' : ''; ?>><?php echo translateString($limit); ?></option>
                <?php } ?>
            </select>
            <?php echo __('items'); ?>
            <span class="ml-1 mr-1">|</span>
            <?php echo __('Showing :count out of :total items', ['count' => $query_count, 'total' => $query_total]); ?>
        </div>
        <div class="col-sm-8 text-sm-right">
            <?php
            /* if ($query->total() > $itemsPerPage) {
                // Pagination keeping the filter parameters
                echo $query->appends(Request::except('page'))->render();
            } else {
                echo __('Page 1');
            } */
            echo $links;
            ?>
        </div>
    </div>

<?php
    return ob_get_clean();
}

/**
 * Add Filter Parameters to Query Arguments.
 *
 * If your db Query key is different than the URL params,
 * then pass and associative array as $additions, if not,
 * you can pass a one-dimentional array of parameters.
 *
 * Usage Instructions:
 * - $additions = array(
 *      'query_key1' => 'parameter1',
 *      'query_key2' => 'parameter2'
 *   );
 * - $additions = array('parameter1', 'parameter2');
 *
 * @param array $args      Array of Arguments.
 * @param array $additions Array of Filter Keys.
 *
 * @return array           Merged Array.
 * -----------------------------------------------------------------------
 */
function filterParams($args, $additions)
{
    if (Arr::isAssoc($additions)) {
        foreach ($additions as $query_key => $param) {
            $_var = Request::input($param);

            if (!empty($_var)) {
                $args = array_merge($args, array($query_key => $_var));
            }
        }
    } else {
        foreach ($additions as $param) {
            $_var = Request::input($param);

            if (!empty($_var)) {
                $args = array_merge($args, array($param => $_var));
            }
        }
    }

    return $args;
}

/**
 * Parse Arguments.
 *
 * Parse user defined arguments and mix them with default
 * arguments defined.
 *
 * Adopted, but modified from WordPress Core.
 *
 * @param array $args     User defined arguments.
 * @param array $defaults Default arguments.
 *
 * @return array          Merged version of arguments.
 * ---------------------------------------------------------------------
 */
function parseArguments($args, $defaults)
{
    if (!is_array($args) || !is_array($defaults)) {
        return 'Both the parameters need to be array';
    }

    $r = &$args;

    return array_merge($defaults, $r);
}



?>
