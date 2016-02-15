<section {$ClassAttr}{$AnchorAttr}>
    <% if Items %>
        <dl>
            <% loop Items %>
                <dt>$Title</dt>
                <dd>
                    $Content
                </dd>
            <% end_loop %>
        </dl>
    <% end_if %>
</section>
