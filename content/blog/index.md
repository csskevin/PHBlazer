{{{ template.[default/header] }}}

# Posts

{{#each content}}
{{#if this.meta.title}}
{{#startswith this.path "blog"}}
- [{{ this.meta.title }}](/{{this.path}})
{{/startswith}}
{{/if}}
{{/each}}

{{{ template.[default/footer] }}}

