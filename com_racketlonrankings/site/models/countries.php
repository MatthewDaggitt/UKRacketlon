<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_racketlonrankings
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$allCountries = array(
	"ABW" => "Aruba", //
	"AFG" => "Afghan",
	"AGO" => "Angolan",
	"AIA" => "Anguilla", //
	"ALA" => "Åland Islands", //
	"ALB" => "Albanian",
	"AND" => "Andorran",
	"ARE" => "United Arab Emirates", //
	"ARG" => "Argentinan",
	"ARM" => "Armenian",
	"ASM" => "American Samoa", //
	"ATA" => "Antarctica", //
	"ATF" => "French Southern Territories", //
	"ATG" => "Antigua and Barbuda", //
	"AUS" => "Australian",
	"AUT" => "Austrian",
	"AZE" => "Azerbaijani",
	"BDI" => "Burundian",
	"BEL" => "Belgian",
	"BEN" => "Beninese",
	"BES" => "Bonaire, Sint Eustatius and Saba", //
	"BFA" => "Burkina Faso", //
	"BGD" => "Bangladeshi",
	"BUL" => "Bulgarian",
	"BGR" => "Bulgarian",
	"BHR" => "Bahraini",
	"BHS" => "Bahamian",
	"BIH" => "Bosnian",
	"BLM" => "Saint Barthélemy", //
	"BLR" => "Belarusian",
	"BLZ" => "Belizean",
	"BMU" => "Bermuda", //
	"BOL" => "Bolivian", //
	"BRA" => "Brazilian", //
	"BRB" => "Barbadian",
	"BRN" => "Brunei Darussalam", //
	"BTN" => "Bhutanese",
	"BVT" => "Bouvet Island", //
	"BWA" => "Botswanan",
	"CAF" => "Central African Republic", //
	"CAN" => "Canadian",
	"CCK" => "Cocos Islands", //
	"SUI" => "Swiss",
	"CHL" => "Chilean",
	"CHI" => "Chinese",
	"CIV" => "Côte d'Ivoire", //
	"CMR" => "Cameroonian", //
	"COD" => "Congolese",
	"COG" => "Congolese",
	"COK" => "Cook Islands", //
	"COL" => "Colombian",
	"COM" => "Comoros", //
	"CPV" => "Cabo Verde", //
	"CRI" => "Costa Rican",
	"CUB" => "Cuban",
	"CUW" => "Curaçao", //
	"CXR" => "Christmas Island", //
	"CYM" => "Cayman Islands", //
	"CYP" => "Cypriot",
	"CZE" => "Czech",
	"GER" => "German",
	"DJI" => "Djiboutian",
	"DMA" => "Dominican",
	"DEN" => "Danish",
	"DOM" => "Dominican", 
	"DZA" => "Algerian",
	"ECU" => "Ecuadorian",
	"EGY" => "Egyptian",
	"ENG" => "English",
	"ERI" => "Eritrean",
	"ESH" => "Western Sahara", //
	"ESP" => "Spanish",
	"EST" => "Estonian",
	"ETH" => "Ethiopian",
	"FIN" => "Finnish",
	"FJI" => "Fijian",
	"FLK" => "Falkland Islands", //
	"FRA" => "French",
	"FRO" => "Faroe Islands", //
	"FSM" => "Micronesian", //
	"GAB" => "Gabonese",
	"GBR" => "British",
	"GEO" => "Georgian",
	"GGY" => "Guernsey", //
	"GHA" => "Ghanaian",
	"GIB" => "Gibraltar", //
	"GIN" => "Guinean",
	"GLP" => "Guadeloupe", //
	"GMB" => "Gambian",
	"GNB" => "Guinea-Bissau", //
	"GNQ" => "Guinean",
	"GRE" => "Greek",
	"GRD" => "Grenadian",
	"GRL" => "Greenland", //
	"GTM" => "Guatemalan",
	"GUF" => "French Guiana", //
	"GUM" => "Guam", //
	"GUY" => "Guyanese",
	"HKG" => "Hong Kong", //
	"HMD" => "Heard Island and McDonald Islands", //
	"HND" => "Honduran",
	"CRO" => "Croatian",
	"HTI" => "Haitian",
	"HUN" => "Hungarian",
	"IDN" => "Indonesian",
	"IMN" => "Manx",
	"IND" => "Indian",
	"IOT" => "British Indian Ocean Territory", //
	"IRL" => "Irish",
	"IRN" => "Iranian",
	"IRQ" => "Iraqi",
	"ISL" => "Icelandic",
	"ISR" => "Israeli",
	"ITA" => "Italian",
	"JAM" => "Jamaican",
	"JEY" => "Jersey", //
	"JOR" => "Jordanian",
	"JPN" => "Japanese",
	"KAZ" => "Kazakh",
	"KEN" => "Kenyan",
	"KGZ" => "Kyrgyzstan", //
	"KHM" => "Cambodian",
	"KIR" => "Kiribati",
	"KNA" => "Saint Kitts and Nevis", //
	"KOR" => "South Korean",
	"KWT" => "Kuwaiti",
	"LAO" => "Lao People's Democratic Republic", //
	"LBN" => "Lebanese",
	"LBR" => "Liberian",
	"LIB" => "Libyan",
	"LCA" => "Saint Lucia",
	"LIE" => "Liechtenstein", //
	"LKA" => "Sri Lankan",
	"LSO" => "Lesotho", //
	"LTU" => "Lithuanian",
	"LUX" => "Luxembourg", //
	"LAT" => "Latvian",
	"MAC" => "Macao", //
	"MAF" => "Saint Martin (French part)", //
	"MAR" => "Moroccan",
	"MCO" => "Monacan",
	"MDA" => "Moldovan",
	"MDG" => "Madagascan",
	"MDV" => "Maldivian",
	"MEX" => "Mexican",
	"MHL" => "Marshall Islands", //
	"MKD" => "Macedonian",
	"MLI" => "Malian",
	"MLT" => "Maltese",
	"MMR" => "Burmese",
	"MNE" => "Montenegrin",
	"MNG" => "Mongolian",
	"MNP" => "Northern Mariana Islands",
	"MOZ" => "Mozambican",
	"MRT" => "Mauritanian",
	"MSR" => "Montserrat", //
	"MTQ" => "Martinique", //
	"MUS" => "Mauritian",
	"MWI" => "Malawian",
	"MYS" => "Malaysian",
	"MYT" => "Mayotte", //
	"NAM" => "Namibian",
	"NCL" => "New Caledonian",
	"NER" => "Nigerien",
	"NFK" => "Norfolk Island", //
	"NGA" => "Nigerian",
	"NIC" => "Nicaraguan",
	"NIU" => "Niue", //
	"NIR" => "Northern Irish",
	"NED" => "Dutch",
	"NOR" => "Norwegian",
	"NPL" => "Nepalese",
	"NRU" => "Nauru", //
	"NZL" => "New Zealand", //
	"OMN" => "Omani",
	"PAK" => "Pakistani",
	"PAN" => "Panamanian",
	"PCN" => "Pitcairn", //
	"PER" => "Peruvian",
	"PHL" => "Filipino",
	"PLW" => "Palau", //
	"PNG" => "Papua New Guinean",
	"POL" => "Polish",
	"PRI" => "Puerto Rican",
	"PRK" => "North Korean",
	"POR" => "Portugese",
	"PRY" => "Paraguayan",
	"PSE" => "Palestinian",
	"PYF" => "French Polynesian",
	"QAT" => "Qatari",
	"REU" => "Réunion", //
	"ROM" => "Romanian",
	"RUS" => "Russian",
	"RWA" => "Rwandan",
	"SCO" => "Scottish",
	"SAU" => "Saudi Arabian",
	"SDN" => "Sudanese",
	"SEN" => "Senegal",
	"SGP" => "Singaporian",
	"SGS" => "South Georgia and the South Sandwich Islands", //
	"SHN" => "Saint Helena, Ascension and Tristan da Cunha", //
	"SJM" => "Svalbard and Jan Mayen", //,
	"SLB" => "Solomon Islands", //
	"SLE" => "Sierra Leonian",
	"SLV" => "El Salvador", //
	"SMR" => "San Marino", //
	"SOM" => "Somalian",
	"SPM" => "Saint Pierre and Miquelon", //
	"SRB" => "Serbian",
	"SSD" => "South Sudanese",
	"STP" => "Sao Tome and Principe", //
	"SUR" => "Suriname", //
	"SVK" => "Slovakian",
	"SLO" => "Slovenian",
	"SWE" => "Swedish",
	"SWZ" => "Swazi",
	"SXM" => "Sint Maarten", //
	"SYC" => "Seychellois", //
	"SYR" => "Syrian",
	"TCA" => "Turks and Caicos Islands", //
	"TCD" => "Chad", //
	"TGO" => "Togolese",
	"THA" => "Thai",
	"TJK" => "Tajik",
	"TKL" => "Tokelau", //
	"TKM" => "Turkmen",
	"TLS" => "Timor-Leste", //
	"TON" => "Tonga", //
	"TTO" => "Trinidadian and Tobagan",
	"TUN" => "Tunisian",
	"TUR" => "Turkish",
	"TUV" => "Tuvaluan",
	"TWN" => "Taiwanese",
	"TZA" => "Tanzanian",
	"UGA" => "Ugandan",
	"UKR" => "Ukrainian",
	"UMI" => "United States Minor Outlying Islands", //
	"URY" => "Uruguayan",
	"USA" => "American",
	"UZB" => "Uzbek",
	"VAT" => "Vatican City", //
	"VCT" => "Saint Vincent and the Grenadines", //
	"VEN" => "Venezuelan",
	"VGB" => "British Virgin Islands", //
	"VIR" => "US Virgin Islands", //
	"VNM" => "Viet Namese",
	"VUT" => "Vanuatuan",
	"WAL" => "Welsh",
	"WLF" => "Wallis and Futuna", //
	"WSM" => "Samoan",
	"YEM" => "Yemeni",
	"RSA" => "South African",
	"ZMB" => "Zambian",
	"ZWE" => "Zimbabwean"
);	
?>