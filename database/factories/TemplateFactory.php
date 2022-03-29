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
<h1>replaceTerm1</h1><p style="margin-left:0px;">replaceTerm2</p><h4>Notable Fixes</h4><ul><li>The “Send Request” hotkey now works for gRPC requests (<a href="https://github.com/Kong/insomnia/pull/4126">#4126</a>)&nbsp;<a href="https://github.com/vincendep"><strong>&nbsp;</strong></a></li><li>Fixed a regression where some OAuth workflows would fail</li><li>Fixed a regression where multipart/form-data requests could not be sent</li><li>circular references in OpenAPI specs should now be allowed (<a href="https://github.com/Kong/insomnia/pull/4040">#4040</a>)&nbsp;</li><li>Will no longer indent with tabs for YAML OpenAPI specs when the&nbsp;indent WithTabs&nbsp;setting is on (<a href="https://github.com/Kong/insomnia/pull/4315">#4315</a>)&nbsp;<a href="https://github.com/develohpanda"><strong>&nbsp;</strong></a></li><li>An extra&nbsp;v&nbsp;will no longer appear in the dashboard for a Design Document's version if the version already starts with&nbsp;v&nbsp;(<a href="https://github.com/Kong/insomnia/pull/4319">#4319</a>)</li></ul><h4>Additions and Other Improvements</h4><ul><li>Now you can configure whether values are shown for environment variable template tags (<a href="https://github.com/Kong/insomnia/pull/4277">#4277</a>)&nbsp;</li><li>Upgraded to Electron 12 (<a href="https://github.com/Kong/insomnia/pull/4232">#4232</a>)&nbsp;</li><li>URL bar will now autofocus when interacting with new requests or switching between requests (<a href="https://github.com/Kong/insomnia/pull/4338">#4338</a>)</li><li>gRPC requests will now appear in the request switcher (<a href="https://github.com/Kong/insomnia/pull/4127">#4127</a>)</li><li>Show request logs in verbose mode (<a href="https://github.com/Kong/insomnia/pull/4368">#4368</a>)</li></ul><h4>Removal</h4><ul><li>Removed EDN prettifying ahead of a move to prettier for all prettifying (<a href="https://github.com/Kong/insomnia/pull/4603"><strong>#4603</strong></a>)</li></ul><h3 style="margin-left:0px;">Tickets</h3><p>replaceTerm3</p><p>&nbsp;</p><p>&nbsp;</p><p>Wiki replaceTerm4</p><p style="margin-left:0px;">Releases <a href="https://gitlab.com/paperstreet/tsv4/members-area/-/releases/Eden-22.12.3">https://gitlab.com/paperstreet/tsv4/members-area/-/releases/Eden-22.12.3</a></p><p style="margin-left:0px;">Releases https://gitlab.com/paperstreet/x-group/x-forge/-/releases/...</p><p style="margin-left:0px;">&nbsp;</p><p style="margin-left:0px;">Tags <a href="https://gitlab.com/paperstreet/tsv4/members-area/-/tags/Eden-22.12.3">https://gitlab.com/paperstreet/tsv4/members-area/-/tags/Eden-22.12.3</a></p><p style="margin-left:0px;">Tags https://gitlab.com/paperstreet/x-group/x-forge/-/tags/v1.0.0-alpha</p><h2 style="margin-left:0px;"><strong>Merge Request&nbsp;</strong></h2><p style="margin-left:0px;"><a href="https://gitlab.com/paperstreet/tsv4/members-area/-/merge_requests/4050/diffs">https://gitlab.com/paperstreet/tsv4/members-area/-/merge_requests/4050/diffs</a></p><p style="margin-left:0px;">&nbsp;</p><h2 style="margin-left:0px;"><strong>Target group(s) affected by this release&nbsp;</strong></h2><hr><ul><li>[x] Eden Codebase</li><li>[ ] Ads</li><li>[ ] Authentication</li><li>[ ] Upsells</li><li>[ ] Memberships</li><li>[ ] Phoenix API</li><li>[ ] Database , Migrations - Seeders&nbsp;</li></ul><p style="margin-left:0px;">&nbsp;</p><h2 style="margin-left:0px;"><strong>Tech group(s) affected by this release&nbsp;</strong></h2><hr><ul><li>[ ] Composer PHP</li><li>[ ] Node Modules JS</li><li>[ ] Storage (S3)</li><li>[ ] Database , Migrations - Seeders&nbsp;</li><li>[x] Environment File (.env)</li></ul><p>&nbsp;</p><p style="margin-left:0px;"><strong>Deployment Commands:&nbsp;</strong></p><pre><code class="language-plaintext"># ( e.g. ) php artisan migrate 

php artisan migrate --force 
php artisan load_movies_to_elastic_search --deleteIndexes
php artisan load_movies_to_elastic_search --createIndexes
php artisan load_movies_to_elastic_search</code></pre><p style="margin-left:0px;"><strong>Environment File (.env) Diff</strong></p><p style="margin-left:0px;">Old Values</p><pre><code class="language-plaintext">&nbsp;</code></pre><p style="margin-left:0px;">New Values</p><pre><code class="language-plaintext">&nbsp;</code></pre><h2 style="margin-left:0px;">Tests <img src="https://pf-emoji-service--cdn.us-east-1.prod.public.atl-paas.net/atlassian/flag_on_32.png" alt=":flag_on:">&nbsp;</h2><p style="margin-left:0px;">UI tests ( N/A)</p><p style="margin-left:0px;"><s>A failed test is not legit, tested manually works fine. N/A</s></p><p style="margin-left:0px;">&nbsp;</p><h2 style="margin-left:0px;"><strong>Post-Release Review (RM Performance Evaluation)</strong></h2><p style="margin-left:0px;">Keep doing :</p><p style="margin-left:0px;">Don't Repeat :</p><p style="margin-left:0px;">root cause.</p><p>replaceTerm5<br>&nbsp;</p>
 
HERE3;
    }
}
