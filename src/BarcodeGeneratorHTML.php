<?php

namespace Picqer\Barcode;

class BarcodeGeneratorHTML extends BarcodeGenerator
{

    /**
     * Return an HTML representation of barcode.
     *
     * @param string $code code to print
     * @param string $type type of barcode
     * @param boolean $showCode Displays the coupon code underneath the barcode if set to true.
     * @param string $codeStyles CSS styles to apply to the coupon code underneath the barcode.
     * @param int $codeHeight Height of the coupon code container, which is added to the height of the parent container so the coupon code is properly displayed.
     * @param int $widthFactor Width of a single bar element in pixels.
     * @param int $totalHeight Height of a single bar element in pixels.
     * @param int|string $color Foreground color for bar elements (background is transparent).
     * @return string HTML code.
     * @public
     */
    public function getBarcode($code, $type, $showCode, $codeStyles, $codeHeight, $widthFactor = 2, $totalHeight = 30, $color = 'black')
    {
        $barcodeData = $this->getBarcodeData($code, $type);

        $html = '<div style="font-size:0;position:relative;width:' . ($barcodeData['maxWidth'] * $widthFactor) . 'px;height:' . ($totalHeight + $codeHeight) . 'px;">' . "\n";

        $positionHorizontal = 0;
        foreach ($barcodeData['bars'] as $bar) {
            $barWidth = round(($bar['width'] * $widthFactor), 3);
            $barHeight = round(($bar['height'] * $totalHeight / $barcodeData['maxHeight']), 3);

            if ($bar['drawBar']) {
                $positionVertical = round(($bar['positionVertical'] * $totalHeight / $barcodeData['maxHeight']), 3);
                // draw a vertical bar
                $html .= '<div style="background-color:' . $color . ';width:' . $barWidth . 'px;height:' . $barHeight . 'px;position:absolute;left:' . $positionHorizontal . 'px;top:' . $positionVertical . 'px;">&nbsp;</div>' . "\n";
            }

            $positionHorizontal += $barWidth;
        }
        
        if($showCode == true) {
            $html .= '<div style="' . $codeStyles . '">' . $code . '</div>' . "\n";
        }

        $html .= '</div>' . "\n";

        return $html;
    }
}
