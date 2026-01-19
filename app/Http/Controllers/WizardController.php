<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\TemplateBuilderService;
use App\Services\ExportService;
use App\Services\Api\ApiTemplateGeneratorService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class WizardController extends Controller
{
    protected $templateBuilder;
    protected $exportService;
    protected $apiGenerator;

    public function __construct(
        TemplateBuilderService $templateBuilder, 
        ExportService $exportService,
        ApiTemplateGeneratorService $apiGenerator
    ) {
        $this->templateBuilder = $templateBuilder;
        $this->exportService = $exportService;
        $this->apiGenerator = $apiGenerator;
    }

    public function index()
    {
        return view('wizard.step1');
    }

    public function step1(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'groups' => 'required|string',
            'vendor_name' => 'nullable|string',
            'vendor_version' => 'nullable|string',
            'description' => 'nullable|string',
            'zabbix_version' => 'required|string',
            'creation_mode' => 'required|in:manual,api',
        ]);

        Session::put('template_data', $validated);

        if ($validated['creation_mode'] === 'api') {
            return redirect()->route('wizard.api_config');
        }

        return redirect()->route('wizard.step2');
    }

    public function showApiConfig()
    {
        return view('wizard.api_config');
    }

    public function apiConfig(Request $request)
    {
        $validated = $request->validate([
            'base_url' => 'required|url',
            'api_type' => 'required|in:REST,SOAP,GraphQL,Custom',
            'auth_type' => 'required|string',
            'endpoints' => 'required|array',
        ]);

        $templateData = Session::get('template_data');
        $templateData['api'] = $validated;
        Session::put('template_data', $templateData);

        // Here we could trigger the ApiAnalyzerService
        return redirect()->route('wizard.finish');
    }

    public function showStep2()
    {
        return view('wizard.step2');
    }

    public function step2(Request $request)
    {
        // Macros and Global Tags
        $data = $request->all();
        $templateData = Session::get('template_data');
        $templateData['macros'] = $data['macros'] ?? [];
        $templateData['tags'] = $data['tags'] ?? [];
        
        Session::put('template_data', $templateData);

        return redirect()->route('wizard.step3');
    }

    public function showStep3()
    {
        return view('wizard.step3');
    }

    public function step3(Request $request)
    {
        // Items
        $templateData = Session::get('template_data');
        $templateData['items'] = $request->input('items', []);
        Session::put('template_data', $templateData);

        return redirect()->route('wizard.step4');
    }

    public function showStep4()
    {
        return view('wizard.step4');
    }

    public function step4(Request $request)
    {
        // Discovery Rules
        $templateData = Session::get('template_data');
        $templateData['discovery_rules'] = $request->input('discovery_rules', []);
        Session::put('template_data', $templateData);

        return redirect()->route('wizard.step5');
    }

    public function showStep5()
    {
        return view('wizard.step5');
    }

    public function step5(Request $request)
    {
        // Triggers
        $templateData = Session::get('template_data');
        $templateData['triggers'] = $request->input('triggers', []);
        Session::put('template_data', $templateData);

        return redirect()->route('wizard.step6');
    }

    public function showStep6()
    {
        return view('wizard.step6');
    }

    public function step6(Request $request)
    {
        // Web Scenarios
        $templateData = Session::get('template_data');
        $templateData['web_scenarios'] = $request->input('web_scenarios', []);
        Session::put('template_data', $templateData);

        return redirect()->route('wizard.finish');
    }

    public function finish()
    {
        $data = Session::get('template_data');
        
        // Actually build the template in memory or DB (using memory here for the export)
        // Since DB might fail due to SQLite driver, I'll implement a way to export from session data too
        // but for now let's assume we want to use the models if possible.
        
        return view('wizard.finish', compact('data'));
    }

    public function export(Request $request)
    {
        $data = Session::get('template_data');
        
        if (isset($data['creation_mode']) && $data['creation_mode'] === 'api') {
            // API Mode: Use the dedicated Generator Service
            $template = $this->apiGenerator->generate($data);
        } else {
            // Manual Mode: Hydrate collections for ExportService
            $template = new \App\Models\Template($data);
            $template->setRelation('items', collect($data['items'] ?? [])->map(fn($i) => new \App\Models\Item($i)));
            $template->setRelation('discoveryRules', collect($data['discovery_rules'] ?? [])->map(fn($dr) => new \App\Models\DiscoveryRule($dr)));
            $template->setRelation('triggers', collect($data['triggers'] ?? [])->map(fn($t) => new \App\Models\Trigger($t)));
            $template->setRelation('macros', collect($data['macros'] ?? [])->map(fn($m) => new \App\Models\Macro($m)));
            $template->setRelation('tags', collect($data['tags'] ?? [])->map(fn($t) => new \App\Models\Tag($t)));
            $template->setRelation('webScenarios', collect($data['web_scenarios'] ?? [])->map(function($ws) {
                $scenario = new \App\Models\WebScenario($ws);
                $scenario->setRelation('steps', collect($ws['steps'] ?? [])->map(fn($s) => new \App\Models\WebStep($s)));
                return $scenario;
            }));
        }
        
        $json = $this->exportService->exportToJson($template);
        
        return response($json)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="'.($template->name ?: 'template').'.json"');
    }
}
