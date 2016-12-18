<?php
namespace backend\controllers;

use common\components\keyStorage\FormModel;
use trntv\filekit\widget\Upload;
use Yii;

/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'base' : 'common';
        return parent::beforeAction($action);
    }

    public function actionSettings()
    {
        $model = new FormModel([
            'keys' => [
                'frontend.maintenance' => [
                    'label' => Yii::t('backend', 'Frontend maintenance mode'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'disabled' => Yii::t('backend', 'Disabled'),
                        'enabled' => Yii::t('backend', 'Enabled')
                    ]
                ],
                'backend.theme-skin' => [
                    'label' => Yii::t('backend', 'Backend theme'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'skin-black' => 'skin-black',
                        'skin-blue' => 'skin-blue',
                        'skin-green' => 'skin-green',
                        'skin-purple' => 'skin-purple',
                        'skin-red' => 'skin-red',
                        'skin-yellow' => 'skin-yellow'
                    ]
                ],
                'backend.layout-fixed' => [
                    'label' => Yii::t('backend', 'Fixed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-boxed' => [
                    'label' => Yii::t('backend', 'Boxed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-collapsed-sidebar' => [
                    'label' => Yii::t('backend', 'Backend sidebar collapsed'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'common.default-avatar' => [
                    'label' => Yii::t('common', 'Default user avatar'),
                    'type' => FormModel::TYPE_WIDGET,
                    'rules' => [['required']],
                    'widget' => Upload::classname(),
                    'options' => [
                        'url'=>['key-storage/avatar-upload']
                    ],
                ],
                'common.publication-name' => [
                    'label' => Yii::t('backend', 'Name of publication'),
                    'type' => FormModel::TYPE_TEXTINPUT,
                ],
                'common.publication-lang' => [
                    'lable' => Yii::t('backend', 'Language of publication'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        "en" => "English",
                        "aa" => "Afar",
                        "ab" => "Abkhazian",
                        "ae" => "Avestan",
                        "af" => "Afrikaans",
                        "ak" => "Akan",
                        "am" => "Amharic",
                        "an" => "Aragonese",
                        "ar" => "Arabic",
                        "as" => "Assamese",
                        "av" => "Avaric",
                        "ay" => "Aymara",
                        "az" => "Azerbaijani",
                        "ba" => "Bashkir",
                        "be" => "Belarusian",
                        "bg" => "Bulgarian",
                        "bh" => "Bihari",
                        "bi" => "Bislama",
                        "bm" => "Bambara",
                        "bn" => "Bengali",
                        "bo" => "Tibetan",
                        "br" => "Breton",
                        "bs" => "Bosnian",
                        "ca" => "Catalan",
                        "ce" => "Chechen",
                        "ch" => "Chamorro",
                        "co" => "Corsican",
                        "cr" => "Cree",
                        "cs" => "Czech",
                        "cu" => "Church Slavic",
                        "cv" => "Chuvash",
                        "cy" => "Welsh",
                        "da" => "Danish",
                        "de" => "German",
                        "dv" => "Divehi",
                        "dz" => "Dzongkha",
                        "ee" => "Ewe",
                        "el" => "Greek",
                        "eo" => "Esperanto",
                        "es" => "Spanish",
                        "et" => "Estonian",
                        "eu" => "Basque",
                        "fa" => "Persian",
                        "ff" => "Fulah",
                        "fi" => "Finnish",
                        "fj" => "Fijian",
                        "fo" => "Faroese",
                        "fr" => "French",
                        "fy" => "Western Frisian",
                        "ga" => "Irish",
                        "gd" => "Scottish Gaelic",
                        "gl" => "Galician",
                        "gn" => "Guarani",
                        "gu" => "Gujarati",
                        "gv" => "Manx",
                        "ha" => "Hausa",
                        "he" => "Hebrew",
                        "hi" => "Hindi",
                        "ho" => "Hiri Motu",
                        "hr" => "Croatian",
                        "ht" => "Haitian",
                        "hu" => "Hungarian",
                        "hy" => "Armenian",
                        "hz" => "Herero",
                        "ia" => "Interlingua (International Auxiliary Language Association)",
                        "id" => "Indonesian",
                        "ie" => "Interlingue",
                        "ig" => "Igbo",
                        "ii" => "Sichuan Yi",
                        "ik" => "Inupiaq",
                        "io" => "Ido",
                        "is" => "Icelandic",
                        "it" => "Italian",
                        "iu" => "Inuktitut",
                        "ja" => "Japanese",
                        "jv" => "Javanese",
                        "ka" => "Georgian",
                        "kg" => "Kongo",
                        "ki" => "Kikuyu",
                        "kj" => "Kwanyama",
                        "kk" => "Kazakh",
                        "kl" => "Kalaallisut",
                        "km" => "Khmer",
                        "kn" => "Kannada",
                        "ko" => "Korean",
                        "kr" => "Kanuri",
                        "ks" => "Kashmiri",
                        "ku" => "Kurdish",
                        "kv" => "Komi",
                        "kw" => "Cornish",
                        "ky" => "Kirghiz",
                        "la" => "Latin",
                        "lb" => "Luxembourgish",
                        "lg" => "Ganda",
                        "li" => "Limburgish",
                        "ln" => "Lingala",
                        "lo" => "Lao",
                        "lt" => "Lithuanian",
                        "lu" => "Luba-Katanga",
                        "lv" => "Latvian",
                        "mg" => "Malagasy",
                        "mh" => "Marshallese",
                        "mi" => "Maori",
                        "mk" => "Macedonian",
                        "ml" => "Malayalam",
                        "mn" => "Mongolian",
                        "mr" => "Marathi",
                        "ms" => "Malay",
                        "mt" => "Maltese",
                        "my" => "Burmese",
                        "na" => "Nauru",
                        "nb" => "Norwegian Bokmal",
                        "nd" => "North Ndebele",
                        "ne" => "Nepali",
                        "ng" => "Ndonga",
                        "nl" => "Dutch",
                        "nn" => "Norwegian Nynorsk",
                        "no" => "Norwegian",
                        "nr" => "South Ndebele",
                        "nv" => "Navajo",
                        "ny" => "Chichewa",
                        "oc" => "Occitan",
                        "oj" => "Ojibwa",
                        "om" => "Oromo",
                        "or" => "Oriya",
                        "os" => "Ossetian",
                        "pa" => "Panjabi",
                        "pi" => "Pali",
                        "pl" => "Polish",
                        "ps" => "Pashto",
                        "pt" => "Portuguese",
                        "qu" => "Quechua",
                        "rm" => "Raeto-Romance",
                        "rn" => "Kirundi",
                        "ro" => "Romanian",
                        "ru" => "Russian",
                        "rw" => "Kinyarwanda",
                        "sa" => "Sanskrit",
                        "sc" => "Sardinian",
                        "sd" => "Sindhi",
                        "se" => "Northern Sami",
                        "sg" => "Sango",
                        "si" => "Sinhala",
                        "sk" => "Slovak",
                        "sl" => "Slovenian",
                        "sm" => "Samoan",
                        "sn" => "Shona",
                        "so" => "Somali",
                        "sq" => "Albanian",
                        "sr" => "Serbian",
                        "ss" => "Swati",
                        "st" => "Southern Sotho",
                        "su" => "Sundanese",
                        "sv" => "Swedish",
                        "sw" => "Swahili",
                        "ta" => "Tamil",
                        "te" => "Telugu",
                        "tg" => "Tajik",
                        "th" => "Thai",
                        "ti" => "Tigrinya",
                        "tk" => "Turkmen",
                        "tl" => "Tagalog",
                        "tn" => "Tswana",
                        "to" => "Tonga",
                        "tr" => "Turkish",
                        "ts" => "Tsonga",
                        "tt" => "Tatar",
                        "tw" => "Twi",
                        "ty" => "Tahitian",
                        "ug" => "Uighur",
                        "uk" => "Ukrainian",
                        "ur" => "Urdu",
                        "uz" => "Uzbek",
                        "ve" => "Venda",
                        "vi" => "Vietnamese",
                        "vo" => "Volapuk",
                        "wa" => "Walloon",
                        "wo" => "Wolof",
                        "xh" => "Xhosa",
                        "yi" => "Yiddish",
                        "yo" => "Yoruba",
                        "za" => "Zhuang",
                        "zh-cn" => "Simplified Chinese",
                        "zh-tw" => "Traditional Chinese",
                        "zu" => "Zulu"
                    ]
                ],
                'common.allowance' => [
                    'label' => Yii::t('backend', 'Number of allowed errors'),
                    'type' => FormModel::TYPE_TEXTINPUT,
                ],
                'common.interval' => [
                    'label' => Yii::t('backend', 'Error timestamp, seconds'),
                    'type' => FormModel::TYPE_TEXTINPUT,
                ],
                'common.blocking-timeout' => [
                    'label' => Yii::t('backend', 'Blocking timeout'),
                    'type' => FormModel::TYPE_TEXTINPUT,
                ],
            ]
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'body' => Yii::t('backend', 'Settings was successfully saved'),
                'options' => ['class' => 'alert alert-success']
            ]);
            return $this->refresh();
        }

        return $this->render('settings', ['model' => $model]);
    }
}
