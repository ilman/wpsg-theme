<?php ob_start(); ?>
[sg_divider_text]Basic List[/sg_divider_text]
[sg_spacer]

[sg_row ]
[sg_col width="4"]
<h4>Unordered List</h4>
<ul>
	<li>Lorem ipsum dolor sit amet</li>
	<li>Consectetur adipisicing elit</li>
	<li>Et dolore voluptatibus</li>
	<li>Corporis incidunt quos cumque</li>
	<li>Accusantium officiis tempore</li>
	<li>Eaque atque facere voluptatem</li>
</ul>
[/sg_col]

[sg_col width="4"]
<h4>Ordered List</h4>
<ol>
	<li>Lorem ipsum dolor sit amet</li>
	<li>Consectetur adipisicing elit</li>
	<li>Et dolore voluptatibus</li>
	<li>Corporis incidunt quos cumque</li>
	<li>Accusantium officiis tempore</li>
	<li>Eaque atque facere voluptatem</li>
</ol>
[/sg_col]

[sg_col width="4"]
<h4>Definition List</h4>
[sg_list_dl]
[sg_dt]Lorem ipsum dolor sit amet[/sg_dt]
[sg_dd]Consectetur adipisicing elit[/sg_dd]
[sg_dt]Et dolore voluptatibus[/sg_dt]
[sg_dd]Corporis incidunt quos cumque[/sg_dd]
[sg_dt]Accusantium officiis tempore[/sg_dt]
[sg_dd]Eaque atque facere voluptatem[/sg_dd]
[/sg_list_dl]
[/sg_col]
[/sg_row]

[sg_spacer]
[sg_divider_text]Horizontal Description[/sg_divider_text]
[sg_spacer]

[sg_list_dl layout="horizontal"]
[sg_dt]Lorem ipsum dolor sit amet[/sg_dt]
[sg_dd]Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod aspernatur natus nulla beatae tempore quaerat ipsa quisquam eius officia impedit.[/sg_dd]
[sg_dt]Et dolore voluptatibus[/sg_dt]
[sg_dd]Facere, eligendi, harum, nobis corporis iste quis temporibus itaque doloribus accusamus laboriosam fuga fugit rem a ea aliquam minima animi perferendis minus ad repellendus veniam nesciunt ex natus labore autem nostrum quidem.[/sg_dd]
[sg_dt]Accusantium officiis tempore[/sg_dt]
[sg_dd]Eaque atque facere voluptatem[/sg_dd]
[/sg_list_dl]

[sg_spacer]
[sg_divider_text]Inline List[/sg_divider_text]
[sg_spacer]


[sg_div class="text-center"]

<h4>Basic Inline</h4>
[sg_list layout="list-inline"]
[sg_li]Lorem ipsum dolor sit amet[/sg_li]
[sg_li]Consectetur adipisicing elit[/sg_li]
[sg_li]Et dolore voluptatibus[/sg_li]
[/sg_list]

[sg_spacer]

<h4>Icon Inline</h4>
[sg_list layout="list-inline"]
[sg_li][sg_fa fixed_width="true" icon="heart" class="text-red"] Lorem ipsum dolor sit amet[/sg_li]
[sg_li][sg_fa fixed_width="true" icon="check" class="text-green"] Consectetur adipisicing elit[/sg_li]
[sg_li][sg_fa fixed_width="true" icon="globe" class="text-blue"] Et dolore voluptatibus[/sg_li]
[/sg_list]

[/sg_div]


[sg_spacer]
[sg_divider_text]Font Awesome List[/sg_divider_text]
[sg_spacer]


[sg_row ]
[sg_col width="4"]
<h4>Font Awesome</h4>
[sg_list_fa]
[sg_li_fa icon="check-square"]Lorem ipsum dolor sit amet[/sg_li_fa]
[sg_li_fa icon="check-square"]Consectetur adipisicing elit[/sg_li_fa]
[sg_li_fa icon="check-square"]Et dolore voluptatibus[/sg_li_fa]
[sg_li_fa icon="check-square"]Corporis incidunt quos cumque[/sg_li_fa]
[sg_li_fa icon="check-square"]Accusantium officiis tempore[/sg_li_fa]
[sg_li_fa icon="check-square"]Eaque atque facere voluptatem[/sg_li_fa]
[/sg_list_fa]
[/sg_col]

[sg_col width="4"]
<h4>Colorized</h4>
[sg_list_fa]
[sg_li_fa icon="star" icon_class="text-yellow"]Lorem ipsum dolor sit amet[/sg_li_fa]
[sg_li_fa icon="star" icon_class="text-yellow"]Consectetur adipisicing elit[/sg_li_fa]
[sg_li_fa icon="star" icon_class="text-yellow"]Et dolore voluptatibus[/sg_li_fa]
[sg_li_fa icon="star" icon_class="text-yellow"]Corporis incidunt quos cumque[/sg_li_fa]
[sg_li_fa icon="star" icon_class="text-yellow"]Accusantium officiis tempore[/sg_li_fa]
[sg_li_fa icon="star" icon_class="text-yellow"]Eaque atque facere voluptatem[/sg_li_fa]
[/sg_list_fa]
[/sg_col]

[sg_col width="4"]
<h4>Combination</h4>
[sg_list_fa]
[sg_li_fa icon="heart" icon_class="text-red"]Lorem ipsum dolor sit amet[/sg_li_fa]
[sg_li_fa icon="check" icon_class="text-green"]Consectetur adipisicing elit[/sg_li_fa]
[sg_li_fa icon="globe" icon_class="text-blue"]Et dolore voluptatibus[/sg_li_fa]
[sg_li_fa icon="magic" icon_class="text-purple"]Corporis incidunt quos cumque[/sg_li_fa]
[sg_li_fa icon="female" icon_class="text-pink"]Accusantium officiis tempore[/sg_li_fa]
[sg_li_fa icon="twitter" icon_class="text-twitter"]Eaque atque facere voluptatem[/sg_li_fa]
[/sg_list_fa]
[/sg_col]
[/sg_row]

[sg_spacer]
[sg_divider_text]Badge List[/sg_divider_text]
[sg_spacer]

[sg_row]
[sg_col width="4" offset="2"]
[sg_list_badge]
[sg_li_badge icon="check" badge_class="bg-green"]
<h5>Lorem ipsum dolor</h5>

[sg_p]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/sg_p]

[/sg_li_badge]
[sg_li_badge icon="check" badge_class="bg-green"]
<h5>Lorem ipsum dolor</h5>

[sg_p]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/sg_p]

[/sg_li_badge]	
[sg_li_badge icon="check" badge_class="bg-green"]
<h5>Lorem ipsum dolor</h5>

[sg_p]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/sg_p]

[/sg_li_badge]	
[/sg_list_badge]
[/sg_col]

[sg_col width="4"]
[sg_list_badge]
[sg_li_badge text="1" badge_class="bg-blue"]
<h5>Lorem ipsum dolor</h5>

[sg_p]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/sg_p]

[/sg_li_badge]
[sg_li_badge text="2" badge_class="bg-blue"]
<h5>Lorem ipsum dolor</h5>

[sg_p]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/sg_p]

[/sg_li_badge]	
[sg_li_badge text="3" badge_class="bg-blue"]
<h5>Lorem ipsum dolor</h5>

[sg_p]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/sg_p]

[/sg_li_badge]	
[/sg_list_badge]
[/sg_col]
[/sg_row]


[sg_spacer]
[sg_divider_text]List Group[/sg_divider_text]
[sg_spacer]


[sg_row]
[sg_col width="4"]
<h4>Basic</h4>
[sg_list_group]
[sg_li_group]Cras justo odio[/sg_li_group]
[sg_li_group]Dapibus ac facilisis in[/sg_li_group]
[sg_li_group]Morbi leo risus[/sg_li_group]
[/sg_list_group]
[/sg_col]

[sg_col width="4"]
<h4>With Badges</h4>
[sg_list_group]
[sg_li_group]Cras justo odio [sg_badge]14[/sg_badge][/sg_li_group]
[sg_li_group]Dapibus ac facilisis in [sg_badge]2[/sg_badge][/sg_li_group]
[sg_li_group]Morbi leo risus [sg_badge]1[/sg_badge][/sg_li_group]
[/sg_list_group]
[/sg_col]

[sg_col width="4"]
<h4>Linked Items</h4>
[sg_list_group type="link"]
[sg_li_group type="link" class="active"]Cras justo odio[/sg_li_group]
[sg_li_group type="link"]Dapibus ac facilisis in[/sg_li_group]
[sg_li_group type="link"]Morbi leo risus[/sg_li_group]
[/sg_list_group]
[/sg_col]
[/sg_row]

<?php $content = ob_get_clean(); ?>

<div style="background:#fff; padding:20px;">
<?php echo do_shortcode($content); ?>
</div>