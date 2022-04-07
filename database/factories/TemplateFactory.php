<?php

namespace Database\Factories;

use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Template::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'     => 'Template Init',
            'document' => $this->getDoc(),
        ];
    }

    public function getDoc(){

        return <<<HERE3
<h1>replaceTerm1</h1>
<p style="margin-left:0px;">replaceTerm2</p>
<h4>Fixes</h4>
<ul>
<li>Fixed a bug with clicking links embedded within XML</li>
<li>Fixed a bug where the keyboard binding for “Show Autocomplete” could not be changed</li>
<li>Fixed a bug where dropdown searching could crash the app in certain cases</li>
<li>Fixed a bug where elements behind a modal could be interacted with in certain cases</li>
<li>Fixed a bug where some response history items could not be activated</li>
<li>Fixed a regression where tab navigation didn’t work in certain cases</li>
<li>Fixed a bug where importing Postman from the dashboard wouldn’t import anything</li>
<li>Fixed a bug where sidebar sorting wouldn’t work</li>
<li>Removed EDN prettifying to prettier for all prettifying</li>
<li>Removed deprecated Insomnia Designer Hotkeys (#4508) @filfreire</li>
</ul>
<h4>Improvements</h4>
<ul>
<li>Improved header spacing to preserve vertical space</li>
<li>Added masking for network proxy settings</li>
<li>Added support for importing GraphQL Postman collections</li>
<li>Added support to specify multiple font families</li><
<li>Now you can configure whether values are shown for environment variable template tags (<a href="https://github.com/Kong/insomnia/pull/4277">#4277</a>)&nbsp;</li>
<li>Upgraded to Electron 12 (<a href="https://github.com/Kong/insomnia/pull/4232">#4232</a>)&nbsp;</li>
<li>Show request logs in verbose mode (<a href="https://github.com/Kong/insomnia/pull/4368">#4368</a>)</li>
<li>Performance and stability improvements. </li>
</ul>
<h3 style="margin-left:0px;">Tickets</h3>
<p>replaceTerm3</p>

<!--
<h3 style="margin-left:0px;">More Details</h3>
<a href="http://localhost/releases/replaceTerm{issue->id}">replaceTerm1</a>
-->

<br>
<!-- Releases & Tags -->
<p style="margin-left:0px;">Releases <a href="https://gitlab.com/paperstreet/tsv4/members-area/-/releases/replaceTerm1">https://gitlab.com/paperstreet/tsv4/members-area/-/releases/replaceTerm1</a></p>
<p style="margin-left:0px;">Tags <a href="https://gitlab.com/paperstreet/tsv4/members-area/-/tags/replaceTerm1">https://gitlab.com/paperstreet/tsv4/members-area/-/tags/replaceTerm1</a></p>

<p style="margin-left:0px;">Releases <a href="https://gitlab.com/paperstreet/x-group/x-forge/-/releases/replaceTerm1">https://gitlab.com/paperstreet/x-group/x-forge/-/releases/replaceTerm1</a></p>
<p style="margin-left:0px;">Tags <a href="https://gitlab.com/paperstreet/x-group/x-forge/-/tags/replaceTerm1">https://gitlab.com/paperstreet/x-group/x-forge/-/tags/replaceTerm1</a></p>

<!-- Merge Request -->
<h2 style="margin-left:0px;"><strong>Merge Request </strong></h2>
<p style="margin-left:0px;">
<a href="https://gitlab.com/paperstreet/tsv4/members-area/-/merge_requests/4050/diffs">https://gitlab.com/paperstreet/tsv4/members-area/-/merge_requests/4050/diffs</a></p>

<!-- Target group -->
<p style="margin-left:0px;">&nbsp;</p><h2 style="margin-left:0px;"><strong>Target group(s) affected by this release&nbsp;</strong></h2><hr>
<ul><li>[ ] Ads</li>
<li>[ ] Authentication</li>
<li>[ ] Upsells</li>
<li>[ ] Memberships</li>
<li>[ ] Phoenix API</li>
<li>[ ] Database , Migrations - Seeders&nbsp;</li></ul>

<!-- Tech group -->
<p style="margin-left:0px;">&nbsp;</p><h2 style="margin-left:0px;"><strong>Tech group(s) affected by this release&nbsp;</strong></h2><hr>
<ul><li>[ ] Composer PHP</li>
<li>[ ] Node Modules JS</li>
<li>[ ] Storage (S3)</li>
<li>[ ] Database , Migrations - Seeders&nbsp;</li>
<li>[x] Environment File (.env)</li></ul>

<!-- Commands -->
<p>&nbsp;</p><p style="margin-left:0px;"><strong>Deployment Commands:&nbsp;</strong></p><pre><code class="language-plaintext"># ( e.g. ) php artisan migrate 
php artisan migrate --force 
php artisan load_movies_to_elastic_search
</code></pre>

<p style="margin-left:0px;">
<strong>Environment File (.env) Diff</strong></p>
<p style="margin-left:0px;">Old Values</p>
<pre><code class="language-plaintext">&nbsp;</code></pre>
<p style="margin-left:0px;">New Values</p>
<pre><code class="language-plaintext">&nbsp;</code></pre>

<h2 style="margin-left:0px;">Tests <img src="https://pf-emoji-service--cdn.us-east-1.prod.public.atl-paas.net/atlassian/flag_on_32.png" alt=":flag_on:"></h2>
<p style="margin-left:0px;">UI tests ( N/A)</p>
<p style="margin-left:0px;"><s>A failed test is not legit, tested manually works fine. N/A</s></p>
<p style="margin-left:0px;">&nbsp;</p><h2 style="margin-left:0px;"><strong>Post-Release Review (RM Performance Evaluation)</strong></h2>
<p style="margin-left:0px;">Keep doing :</p><p style="margin-left:0px;">Don't Repeat :</p><p style="margin-left:0px;">root cause.</p>


<h2 style="margin-left:0px;"><strong>Tags </strong></h2>
<p style="margin-left:0px;">Message</p>
replaceTerm5
<p style="margin-left:0px;">Release notes</p>
replaceTerm6
 
HERE3;
    }
}
