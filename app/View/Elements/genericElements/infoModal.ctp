<?php
    /*
     * Generic modal builder
     *
     * Simply pass a JSON with the following keys set:
     * - title: A title for the modal
     * - content: array of ordered content elements
     *   - title: A label for a content element (optional)
     *   - paragraph: Text to be displayed (optional)
     *   - html: HTML to be displayed directly (optional)
     *   - code: Code snipet to be displayed - copy pastable (optional)
     * - type: Controls the size of the modal (`xl` or `lg`)
     * - class: A class to be applied on the modal (For reference or customization)
     */
    $contents = '';
    foreach ($data['content'] as $content) {
        $contents .= sprintf(
            '%s%s%s%s',
            empty($content['title']) ? '' : sprintf('<h4>%s</h4>', h($content['title'])),
            empty($content['paragraph']) ? '' : sprintf('<p>%s</p>', h($content['paragraph'])),
            empty($content['html']) ? '' : sprintf('<div class="modalContentHtmlDiv">%s</div>', $content['html']),
            empty($content['code']) ? '' : sprintf('<pre class="quickSelect" onClick="quickSelect(this);">%s</pre>', h($content['code']))
        );
    }
    $action = $this->request->params['action'];
    $controller = $this->request->params['controller'];
    echo sprintf(
        '<div id="genericModal" class="modal %s hide fade %s" tabindex="-1" role="dialog" aria-labelledby="genericModalLabel" aria-hidden="true">%s%s%s</div>',
        isset($type) ? sprintf('modal-%s', $type) : '',
        isset($class) ? $class : '',
        sprintf(
            '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="genericModalLabel">%s</h3></div>',
            empty($data['title']) ?
                h(Inflector::humanize($action)) . ' ' . h(Inflector::singularize(Inflector::humanize($controller))) :
                h($data['title'])
        ),
        sprintf(
            '<div class="modal-body modal-body-%s">%s</div>',
            isset($type) ? $type : 'long',
            $contents
        ),
        sprintf(
            '<div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true" onClick="%s">%s</button></div>',
            'cancelPopoverForm();',
            __('Cancel')
        )
    );
?>
