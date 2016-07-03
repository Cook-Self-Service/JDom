<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <     JDom Class - Cook Self Service library    |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		2.5
* @package		Cook Self Service
* @subpackage	JDom
* @license		GNU General Public License
* @author		Jocelyn HUARD
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class JDomHtmlFlyDecimal extends JDomHtmlFly
{
	protected $decimals;
	protected $decimalPoint;
	protected $thousandsSeparator;
	protected $roundingMethod;
	protected $emptyZero;

	/*
	 * Constuctor
	 *
	 *  @decimals			: Number of decimals
	 *  @decimalPoint		: Decimal point char
	 *  @thousandsSeparator	: Split string in thousands, millions,... specify the character to use
	 *  @roundingMethod		: In case of decimals superior to the limit, how to convert ? 'round', 'floor', 'ceil'
	 *  @emptyZero			: Hide the string if value equals zero
	 *
	 */
	function __construct($args)
	{
		parent::__construct($args);
		$this->arg('decimals' , null, $args, 0);
		$this->arg('decimalPoint' , null, $args, (defined('DECIMAL_POINT')?DECIMAL_POINT:'.'));
		$this->arg('thousandsSeparator' , null, $args, "'");
		$this->arg('roundingMethod' , null, $args, "round");
		$this->arg('emptyZero' , null, $args, false);

	}

	function build()
	{
		// Hide the value when equals to zero
		if (($this->emptyZero) && (($this->dataValue == '0') || ($this->dataValue === 0)))
			return '';

		$value = $this->dataValue;

		$dp = $this->decimalPoint;
		$nbDecimals = (int)$this->decimals;
		$multiple = pow(10, $nbDecimals);

		// round the value to the decimals
		switch($this->roundingMethod)
		{
			// Round decimals to the lower value
			case 'floor':
				$value = floor($value * $multiple) / $multiple;
				break;

			// Round decimals to the upper value
			case 'ceil':
				$value = ceil($value * $multiple) /  $multiple;
				break;

			// Round decimals to the closest value
			case 'round':
			default:
				$value = round($value, $nbDecimals);
				break;
		}


		// Integer number
		if ((int)$value == $value)
		{
			$integerPart = $value;
			$decimalsPart = "";

		}
		else
		{
			$integerPart = substr($value, 0, strpos((string)$value, '.'));
			$decimalsPart = substr($value, strpos((string)$value, '.') + 1);
		}


		// Split thousands
		if ($this->thousandsSeparator)
		{
			$newIntergerPart = "";
			$count = 0;
			for($i = strlen($integerPart) ; $i-- ; $i > 0)
			{
				$number = substr($integerPart, $i, 1);

				if ($count == 3)
				{
					$newIntergerPart = $this->thousandsSeparator . $newIntergerPart;
					$count = 0;
				}

				$newIntergerPart = $number . $newIntergerPart;

				$count++;
			}


			$integerPart = $newIntergerPart;
		}

		// Pad with ending zeros
		$decimalsPart = str_pad($decimalsPart, $this->decimals, '0', STR_PAD_RIGHT);

		// Recompose the string
		$html = $integerPart . ($nbDecimals>0?$dp . $decimalsPart:'');

		return $html;
	}

}