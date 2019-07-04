<?php
/**
* this function renders main menu.
* generally "included how to use tags" information.
**/
function LF_main_menu_view_creator()
{
    echo '<div class="LF-header">
    <img src="'.plugins_url('assets/images/LF-Listings-logo-sm.png',__FILE__).'" alt="" width="250">
    </div>';
    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">'.get_admin_page_title().'</h1>';
    ?>
    <div class="intro" id="intro">
        <h4>How do LF-Listings tags work with WordPress?</h4>
        <p>To display your CREA<sup>&reg;</sup> DDF<sup>&reg;</sup> listings on any page of your WordPress website, you have to place an LF-Listings tag on that page. This is similar to many other WordPress plugins that use the same method to display their specific content on the pages where you like it to appear.</p>
        <br>
        <h4>How does a LF-Listings tag look like?</h4>
        <p>The most basic tag that displays all listings in your data feed looks like this:</p>
        <p>[LF-Listings]</p>
        <br>
        <h4>How to Use Tag Parameters to Customize the Listings Display?</h4>
	<p>The basic tag uses the settings that you have pre-configured on the <a href="<?php echo admin_url('admin.php?page=LF-setting');?>">Settings</a> page. To override or amend those settings for a specific tag, you can use one or combine multiple parameters.</p>
 
        <strong>Example of a customized LF-Listings tag</strong>
        <p>[LF-Listings type="residential" sale="rent" location="Toronto" list-per-page="12"]</p>
        <p>This tag will show the output of the following query: Show only residential properties that are for rent in Toronto. Display 12 listings per page. If there are more than 12 listings in the query, the pagination will link to the additional listings. As you can see, the tags are a powerful way to customize the display of the listings in your data feed.</p>
        
        <br>
        <h4>Can I use multiple tags on the same WordPress page?</h4>
        <p>Yes, you can use multiple LF-Listings tags on the same WordPress page to display different subsets of your data feed in different areas on the page. For instance, you could create a carousel that displays your own listings and below that, you display a grid of the listings available by all agents in your office.</p>
        <p>This would look like this:</p>
        <p>[LF-Listings style="horizontal" agent="MyAgentID"]</p>
    </div>
    <br>
    <!-- Table of Tag Parameters -->
    <h4>Table of Available Parameters for the LF-Listings Tag</h4>
    <div class="table" id="main">
        <table border="1" cellpadding="6" class="wp-list-table widefat fixed striped">
            <tbody>
                <tr>
                    <th scope="col"><b>Parameter</b></th>
                    <th scope="col"><b>Options</b></th>
                    <th scope="col"><b>Description</b></th>
                    <th scope="col"><b>Example</b></th>
                </tr>
                <!-- type -->
                <tr>
                    <td>type</td>
                    <td>
                        <ul class="options">
                            <li>residential</li>
                            <li>commercial</li>
                            <li>condo (For Condo/Strata)</li>
                            <li>recreational</li>
                            <li>agriculture</li>
                            <li>land (For Vacant Land)</li>
                        </ul>
                    </td>
                    <td>It selects from the options of property types that are available in the feed.</td>
                    <td>[LF-Listings type="residential"]</td>
                </tr>
                <!-- sale -->
                <tr>
                    <td>sale</td>
                    <td>
                        <ul class="options">
                            <li>sale</li>
                            <li>rent</li>
                        </ul>
                    </td>
                    <td>It displays properties for sale or property for rent. To display both, remove parameter.</td>
                    <td>[LF-Listings sale="rent"]</td>
                </tr>
                <!-- location -->
                <tr>
                    <td>location</td>
                    <td>
                        <ul class="options">
                            <li>Community 1</li>
                            <li>Community 2</li>
                            <li>Community 3</li>
                        </ul>
                    </td>
                    <td>It displays all listings available in the feed for the selected location (e.g. "Toronto"). For the location parameter to work, locations must be set up on the Settings page first.</td>
                    <td>[LF-Listings location="Toronto"]</td>
                </tr>
                <!-- agent -->
                <tr>
                    <td>agent</td>
                    <td>
                        <ul class="options">
                            <li>CREA Agent ID</li>
                        </ul>
                    </td>
                    <td>It shows all listings in the feed belonging to the agent or multiple agents. CREA Agent ID or multiple Agent IDs, separated by commas.</td>
                    <td>[LF-Listings agent="123456,234567,345678"]</td>
                </tr>
                <!-- office -->
                <tr>
                    <td>office</td>
                    <td>
                        <ul class="options">
                            <li>CREA Office ID</li>
                        </ul>
                    </td>
                    <td>It shows all listings in the feed belonging to the office or multiple offices. CREA Office ID or multiple Office IDs, separated by commas.</td>
                    <td>[LF-Listings office="123456,234567,345678"]</td>
                </tr>
                <!-- style -->
                <tr>
                    <td>search</td>
                    <td>
                        <ul class="options">
                            <li>yes</li>
                            <li>no</li>
                            <li>only</li>
                        </ul>
                    </td>
                    <td>It displays or suppresses the search bar above the listings. Parameter "only" displays a search bar without listings.</td>
                    <td>[LF-Listings search="no"]</td>
                </tr>
                <!-- style -->
                <tr>
                    <td>style</td>
                    <td>
                        <ul class="options">
                            <li>grid</li>
                            <li>horizontal</li>
                        </ul>
                    </td>
                    <td>It displays listings gallery style or carousel style.</td>
                    <td>[LF-Listings style="horizontal"]</td>
                </tr>
                <!-- ids -->
                <tr>
                    <td>ids</td>
                    <td>
                        <ul class="options">
                            <li>Listing ID</li>
                        </ul>
                    </td>
                    <td>To display multiple selected listings, use comma separated Listing IDs.</td>
                    <td>[LF-Listings ids="123456,234567,345678"]</td>
                </tr>
                <!-- priceorder -->
                <tr>
                    <td>priceorder</td>
                    <td>
                        <ul class="options">
                            <li>up</li>
                            <li>down</li>
                            <li>no</li>
                        </ul>
                    </td>
                    <td>It displays or suppresses the "Order by price: Low/High" toggle above and below the listings.</td>
                    <td>[LF-Listings priceorder="no"]</td>
                </tr>
                <!-- pagination -->
                <tr>
                    <td>pagination</td>
                    <td>
                        <ul class="options">
                            <li>yes</li>
                            <li>no</li>
                        </ul>
                    </td>
                    <td>It displays or suppresses the pagination bars above and below the listings.</td>
                    <td>[LF-Listings pagination="no"]</td>
                </tr>
                <!-- popup -->
                <tr>
                    <td>popup</td>
                    <td>
                        <ul class="options">
                            <li>no</li>
                            <li>yes</li>
                        </ul>
                    </td>
                    <td>It suppresses or displays the "terms and condition" popup on the page.</td>
                    <td>[LF-Listings popup="no"]</td>
                </tr>
                <!-- columns -->
                <tr>
                    <td>columns</td>
                    <td>
                        <ul class="options">
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                            <li>4</li>
                        </ul>
                    </td>
                    <td>It displays the number of columns. The tag supports a setting from one to four. If the parameter is not set, the default value as defined on the settings page is used.</td>
                    <td>[LF-Listings columns="4"]</td>
                </tr>
                <!-- list-per-page -->
                <tr>
                    <td>list-per-page</td>
                    <td>
                        <ul class="options">
                            <li>Numeric Value (max limit="48")</li>
                        </ul>
                    </td>
                    <td>It determines the number of listings that are displayed per page. The value is limited to "48". If the parameter is not set, the default setting as defined on the settings page is used.</td>
                    <td>[LF-Listings list-per-page="12"]</td>
                </tr>
                <!-- waterfront -->
                <tr>
                    <td>waterfront</td>
                    <td>
                        <ul class="options">
                            <li>yes</li>
                        </ul>
                    </td>
                    <td>Only listings that are marked "waterfront" will be displayed.</td>
                    <td>[LF-Listings waterfront="yes"]</td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
    echo '</div>';
}
?>
