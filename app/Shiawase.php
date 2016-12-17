<?php

namespace App;

use Illuminate\Support\Collection;

class Shiawase
{
    /**
     * Get an inspiring quote.
     *
     * Taylor & Dayle made this commit from Jungfraujoch. (11,333 ft.)
     *
     * May McGinnis always control the board. #LaraconUS2015
     *
     * @return string
     */
    public static function gift()
    {
        return Collection::make([
            'ご結婚おめでとうございます
末永くお幸せにね',
            '結婚おめでとう！
2人の新居にお邪魔できる日を楽しみにしていますね！',
            'ご結婚おめでとうございます！
新生活のスタート　二人の希望に満ちた未来を祝して○○を贈ります！',
            'ご結婚おめでとう
いつまでも恋人同士のような　笑顔いっぱいのお二人でいてください',
            'ご結婚おめでとうございます！
幸せのお裾分けをいただきに　ぜひ新居へお邪魔させてくださいね',
            'HAPPY WEDDING☆
お二人のことですから　きっと誰もが羨ましくなるステキな家庭をおつくりになるでしょう！',
            'ステキなお二人のご結婚おめでとうございます
幸せいっぱい　夢いっぱいの花嫁さん花婿さんにカンパ～イ！',
            'ご結婚を祝し　遥かな地より心からお慶びを申し上げると共に　末永く幸多かれとお祈り申し上げております',
            'ご結婚　心よりご祝福申しあげます
笑顔の溢れる温かいご家庭をお築きになられますようお祈りいたします',
            '御結婚おめでとうございます
お二人の人生最良の門出を　心からお喜び申し上げます',
            'ご結婚おめでとうございます
お二人で力を合わせて　明るく幸せな家庭を築いてください'
        ])->random();
    }
}
