[layerslider id="1"]
<div class="xqPage">
    <?php
global $wpdb;
$productArray = $wpdb->get_results("SELECT `ID`, `product_name`, `product_price`, `product_dealer_price`, `product_type`, `product_paytype`, `product_show`, `product_description` FROM `xq_products` WHERE product_show='1'");
?>
    <div class="xqProductList">
        <table>
            <tr>
                <td style="width: 33%;padding: 20px;">
                    <?php echo $productArray[0]->product_description;?>
                </td>
                <td style="width: 0.5%;"></td>
                <td style="width: 33%;padding: 20px;">
                    <?php echo $productArray[1]->product_description;?>
                </td>
                <td style="width: 0.5%;"></td>
                <td style="width: 33%;padding: 20px;">
                    <?php echo $productArray[2]->product_description;?>
                </td>
            </tr>
        </table>
    </div>
    <div class="xqProductList">
        <table>
            <tr>
                <td style="width: 33%;padding: 20px;">
                    服务优势：
                    <br> [dt_list style="1" bullet_position="middle" dividers="true"] [dt_list_item image=""]优势一[/dt_list_item] [dt_list_item image=""]优势二[/dt_list_item] [dt_list_item image=""]优势三[/dt_list_item] [/dt_list]
                </td>
                <td style="width: 0.5%;"></td>
                <td style="width: 33%;padding: 20px;">
                    合作伙伴：
                    <br> 展示四个logo，并在下面附上“欢迎加入我们”超链接文本，连接至“加盟轩祺”页面。
                    <br>
                    <a href="http://www.caringyou.com.cn/%E5%8A%A0%E7%9B%9F%E8%BD%A9%E7%A5%BA/">加入我们</a>
                </td>
                <td style="width: 0.5%;"></td>
                <td style="width: 33%;padding: 20px;">
                    第三块使用shortcodes里的blog mini，样式选择“post with rectangular images”
                </td>
            </tr>
        </table>
    </div>
    <div class="xqProductList">
        [vc_row margin_top="0" margin_bottom="0" full_width="" padding_left="0" padding_right="0" animation="" type="" bg_color="" bg_position="top" bg_repeat="no-repeat" bg_cover="false" bg_attachment="false" padding_top="0" padding_bottom="0" enable_parallax="" parallax_speed="0.1" bg_video_src_mp4="" bg_video_src_ogv="" bg_video_src_webm="" bg_type="" parallax_style="" bg_image_new="" layer_image="" bg_image_repeat="" bg_image_size="" bg_cstm_size="" bg_img_attach="" parallax_sense="" bg_image_posiiton="" animation_direction="" animation_repeat="" video_url="" video_url_2="" u_video_url="" video_opts="" video_poster="" u_start_time="" u_stop_time="" viewport_vdo="" enable_controls="" bg_override="" disable_on_mobile_img_parallax="" parallax_content="" parallax_content_sense="" fadeout_row="" fadeout_start_effect="" enable_overlay="" overlay_color="" overlay_pattern="" overlay_pattern_opacity="" overlay_pattern_size="" overlay_pattern_attachment="" multi_color_overlay="" multi_color_overlay_opacity="" seperator_enable="" seperator_type="" seperator_position="" seperator_shape_size="" seperator_svg_height="" seperator_shape_background="" seperator_shape_border="" seperator_shape_border_color="" seperator_shape_border_width="" icon_type="" icon="" icon_size="" icon_color="" icon_style="" icon_color_bg="" icon_border_style="" icon_color_border="" icon_border_size="" icon_border_radius="" icon_border_spacing="" icon_img="" img_width="" ult_hide_row="" ult_hide_row_large_screen="" ult_hide_row_desktop="" ult_hide_row_tablet="" ult_hide_row_tablet_small="" ult_hide_row_mobile="" ult_hide_row_mobile_large=""][vc_column width="1/1" animation=""]
        [dt_call_to_action content_size="big" background="fancy" line="false" style="0"]
        点击<a href="">购买</a>产品。
        [/dt_call_to_action][/vc_column][/vc_row]
    </div>
</div>
<?php ?>
