<template>
  <r64-panel-item
    :field="field"
    :hide-label="field.hideLabelInDetail"
  >
    <r64-excerpt
      slot="value"
      :content="field.value"
      :excerpt-classes="field.excerptClasses"
      :show-label="field.showContentLabel"
      :hide-label="field.hideContentLabel"
    >
      <template slot="content">
        <RowHeading :fields="field.fields" />
        <div
          v-for="row in values"
          :key="row.row_id"
          class="flex border-40 border"
        >
          <p
            v-for="f in field.fields"
            :key="`${row.row_id}${f.attribute}`"
              :class="f.fieldClasses"
          >{{ row[f.attribute] }}</p>
        </div>
      </template>
    </r64-excerpt>
  </r64-panel-item>
</template>

<script>
import RowHeading from './RowHeading';
import RowField from './RowField';

export default {
  mixins: [RowField],

  components: { RowHeading },

  props: ['resource', 'resourceName', 'resourceId', 'field']
};
</script>
