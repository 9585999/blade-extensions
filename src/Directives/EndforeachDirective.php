<?php
namespace Radic\BladeExtensions\Directives;

class EndforeachDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(\\s*)/';

    protected $replace = <<<'EOT'
$1<?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>$2
EOT;

}
