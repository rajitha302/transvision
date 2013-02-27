<?php
namespace Transvision;

// Include all strings
$tmx_source = Utils::getRepoStrings($sourceLocale, $check, $spanishes);
$tmx_target = Utils::getRepoStrings($locale, $check, $spanishes);



// Regex options
$whole_word     = ($check['whole_word']) ? '\b' : '';
$case_sensitive = ($check['case_sensitive']) ? '' : 'i';

$regex = '/' . $whole_word . $recherche . $whole_word . '/' . $case_sensitive;
$entities = preg_grep($regex, array_keys($tmx_source));

if ($check['perfect_match']) {
    $locale1_strings = preg_grep($regex, $tmx_source);
    $locale2_strings = preg_grep($regex, $tmx_target);
} else {
    $search = Utils::uniqueWords($initial_search);
    $locale1_strings = $tmx_source;
    $locale2_strings = $tmx_target;
    foreach ($search as $word ) {
        $regex = '/' . $whole_word . preg_quote($word, '/') . $whole_word . '/' . $case_sensitive;
        $locale1_strings = preg_grep($regex, $locale1_strings);
        $locale2_strings = preg_grep($regex, $locale2_strings);
    }
}

$results_limit = 200;
if (count($locale1_strings) > $results_limit ) {
    array_splice($locale1_strings, $results_limit);
}

if (count($locale2_strings) > $results_limit ) {
    array_splice($locale2_strings, $results_limit);
}
unset($results_limit);

if ( $check['search_type'] == 'strings_entities') {
    foreach ($entities as $entity) {
        $locale1_strings[$entity] = $tmx_source[$entity];
    }
}
