<?php
namespace Radic\BladeExtensions\Seven\Directives;

class MarkdownDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@markdown(?!\\()(\\s*)/';

    protected $replace = <<<'EOT'
$1<?php echo app("blade.helpers")->get('markdown')->parse(<<<'EOT'$2
EOT;


}
