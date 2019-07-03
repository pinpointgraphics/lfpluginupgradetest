<?php

// Plugin updater clas for LF listings
class LF_Listings_Plugin_Updater {

    private $slug;

    private $pluginData;

    private $username;

    private $repo;

    private $pluginFile;

    private $githubAPIResult;

    private $accessToken;

    private $pluginActivated;

    /**
     * Class constructor.
     *
     * @param  string $pluginFile
     * @param  string $gitHubUsername
     * @param  string $gitHubProjectName
     * @param  string $accessToken
     * @return null
     */
    function __construct( $pluginFile, $gitHubUsername, $gitHubProjectName, $accessToken = '' )
    {
        add_filter( "pre_set_site_transient_update_plugins", array( $this, "setTransitent" ) );
        add_filter( "plugins_api", array( $this, "setPluginInfo" ), 10, 3 );
        add_filter( "upgrader_pre_install", array( $this, "preInstall" ), 10, 3 );
        add_filter( "upgrader_post_install", array( $this, "postInstall" ), 10, 3 );

        $this->pluginFile 	= $pluginFile;
        $this->username 	= $gitHubUsername;
        $this->repo 		= $gitHubProjectName;
        $this->accessToken 	= $accessToken;
    }

    /**
     * Get information regarding our plugin from WordPress
     *
     * @return null
     */
    private function initPluginData()
    {
		$this->slug = plugin_basename( $this->pluginFile );

		$this->pluginData = get_plugin_data( $this->pluginFile );
    }

    /**
     * Get information regarding our plugin from GitHub
     *
     * @return null
     */
    private function getRepoReleaseInfo()
    {
        if ( ! empty( $this->githubAPIResult ) )
        {
    		return;
		}

		// Query the GitHub API
		$url = "https://api.github.com/repos/{$this->username}/{$this->repo}/releases";

		if ( ! empty( $this->accessToken ) )
		{
		    $url = add_query_arg( array( "access_token" => $this->accessToken ), $url );
		}

		// Get the results
		$this->githubAPIResult = wp_remote_retrieve_body( wp_remote_get( $url ) );

		if ( ! empty( $this->githubAPIResult ) )
		{
		    $this->githubAPIResult = @json_decode( $this->githubAPIResult );
		}

		// Use only the latest release
		if ( is_array( $this->githubAPIResult ) )
		{
		    $this->githubAPIResult = $this->githubAPIResult[0];
		}
    }

    /**
     * Push in plugin version information to get the update notification
     *
     * @param  object $transient
     * @return object
     */
    public function setTransitent( $transient )
    {
        if ( empty( $transient->checked ) )
        {
    		return $transient;
		}

		// Get plugin & GitHub release information
		$this->initPluginData();
		$this->getRepoReleaseInfo();

		$doUpdate = version_compare( $this->githubAPIResult->tag_name, $transient->checked[$this->slug] );

		if ( $doUpdate )
		{
			$package = $this->githubAPIResult->zipball_url;

			if ( ! empty( $this->accessToken ) )
			{
			    $package = add_query_arg( array( "access_token" => $this->accessToken ), $package );
			}

			// Plugin object
			$obj = new stdClass();
			$obj->slug = $this->slug;
			$obj->new_version = $this->githubAPIResult->tag_name;
			$obj->url = $this->pluginData["PluginURI"];
			$obj->package = $package;

			$transient->response[$this->slug] = $obj;
		}

        return $transient;
    }

    /**
     * Push in plugin version information to display in the details lightbox
     *
     * @param  boolean $false
     * @param  string $action
     * @param  object $response
     * @return object
     */
    public function setPluginInfo( $false, $action, $response )
    {
		$this->initPluginData();
		$this->getRepoReleaseInfo();

		if ( empty( $response->slug ) || $response->slug != $this->slug )
		{
		    return $false;
		}

		// Add our plugin information
		$response->last_updated = $this->githubAPIResult->published_at;
		$response->slug = $this->slug;
		$response->plugin_name  = $this->pluginData["Name"];
		$response->version = $this->githubAPIResult->tag_name;
		$response->author = $this->pluginData["AuthorName"];
		$response->homepage = $this->pluginData["PluginURI"];

		// This is our release download zip file
		$downloadLink = $this->githubAPIResult->zipball_url;

		if ( !empty( $this->accessToken ) )
		{
		    $downloadLink = add_query_arg(
		        array( "access_token" => $this->accessToken ),
		        $downloadLink
		    );
		}

		$response->download_link = $downloadLink;

		// Load Parsedown
		require_once __DIR__ . DIRECTORY_SEPARATOR . 'Parsedown.php';

		// Create tabs in the lightbox
		$response->sections = array(
			'Description' 	=> $this->pluginData["Description"],
			'changelog' 	=> class_exists( "Parsedown" )
				? Parsedown::instance()->parse( $this->githubAPIResult->body )
				: $this->githubAPIResult->body
		);

		// Gets the required version of WP if available
		$matches = null;
		preg_match( "/requires:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches );
		if ( ! empty( $matches ) ) {
		    if ( is_array( $matches ) ) {
		        if ( count( $matches ) > 1 ) {
		            $response->requires = $matches[1];
		        }
		    }
		}

		// Gets the tested version of WP if available
		$matches = null;
		preg_match( "/tested:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches );
		if ( ! empty( $matches ) ) {
		    if ( is_array( $matches ) ) {
		        if ( count( $matches ) > 1 ) {
		            $response->tested = $matches[1];
		        }
		    }
		}

        return $response;
    }

    /**
     * Perform check before installation starts.
     *
     * @param  boolean $true
     * @param  array   $args
     * @return null
     */
    public function preInstall( $true, $args )
    {
        // Get plugin information
		$this->initPluginData();

		// Check if the plugin was installed before...
    	$this->pluginActivated = is_plugin_active( $this->slug );
    }

    /**
     * Perform additional actions to successfully install our plugin
     *
     * @param  boolean $true
     * @param  string $hook_extra
     * @param  object $result
     * @return object
     */
    public function postInstall( $true, $hook_extra, $result )
    {
		global $wp_filesystem;

		// Since we are hosted in GitHub, our plugin folder would have a dirname of
		// reponame-tagname change it to our original one:
		$pluginFolder = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname( $this->slug );
		$wp_filesystem->move( $result['destination'], $pluginFolder );
		$result['destination'] = $pluginFolder;

		// update the css
		require_once LF_PLUGIN_DIR.'/inc/functions.php';
		$pluginData = get_plugin_data(LF_PLUGIN_DIR.'/LF-Listings.php');
        	$currentVersion = $pluginData['Version'];
        	$lastVersion= LF_get_settings('last_css_updated_version');
	        if(empty($lastVersion))
        	{
                	$lastVersion = '1.0.0';
	                LF_add_settings('last_css_updated_version',$lastVersion);
        	}
		file_put_contents(plugin_dir_path( __FILE__ ).'assets/css/style.css',stripslashes_deep(LF_get_settings('customCss')));
		$digits = explode (".", $lastVersion);
		$cssDir = plugin_dir_path( __FILE__ ).'versioned_css/';
		$digits[2]++;
		for ($digits[0]; $digits[0] <=1; $digits[0]++) {
        		for ($digits[1]; $digits[1] <=1; $digits[1]++) {
                		for ($digits[2]; $digits[2] <=25; $digits[2]++) {
                        		$version = implode('.', $digits);
	                        	echo $version."\n";
	        	                $cssFile = $cssDir.$version.".css";
        	        	        if(file_exists ($cssFile))
                	        	{
        	                	        file_put_contents(plugin_dir_path( __FILE__ ).'assets/css/style.css', "\n\n----- ".$version." append -----\n\n", FILE_APPEND | LOCK_EX);
                	                	file_put_contents(plugin_dir_path( __FILE__ ).'assets/css/style.css', file_get_contents($cssFile), FILE_APPEND | LOCK_EX);
	                        	}
		                        if($currentVersion == $version)
        		                {
                		                break 3;
                        		}
			       }
			       $digits[2] = 0;
		   	}
			$digits[1] = 0;
		}
		LF_add_settings('customCss',file_get_contents(plugin_dir_path( __FILE__ ).'assets/css/style.css'));	


		// Re-activate plugin if needed
		if ( $this->pluginActivated )
		{
		    $activate = activate_plugin( $this->slug );
		}

        return $result;
    }
}
