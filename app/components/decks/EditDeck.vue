<template>
  <bui-frame>
    <bui-toolbar :title="isNew ? 'Add Deck' : 'Update Deck'"
                 show-back-icon
                 @back::clicked="$router.back()">
      <div slot="actions">
      </div>
    </bui-toolbar>
    <bui-form class="edit-card">
      <bui-input name="title" v-model="override.title" placeholder="Title"></bui-input>
      <bui-input type="textarea" name="description" v-model="override.description" placeholder="Description" :rows="4"></bui-input>
      <bui-input name="resource" v-model="override.resourceUrl" label="Resource URL" placeholder="eg. http://domaine.tls/my-resource.png"></bui-input>
      <label>
        Use Spelling
        <input type="checkbox" name="use_spell" v-model="override.useSpell">
      </label>
      <div v-if="override.useSpell">
        <bui-select name="front_spell" label="frontSpell" v-model="override.frontSpell">
          <bui-select-option v-for="code in countryCode" :value="code.id">{{ code.name }}</bui-select-option>
        </bui-select>
        <bui-select name="back_spell" label="backSpell" v-model="override.backSpell">
          <bui-select-option v-for="code in countryCode" :value="code.id">{{ code.name }}</bui-select-option>
        </bui-select>
      </div>
      <div>
        <bui-button @click.native="cancel">Cancel</bui-button>
        <bui-button @click.native="save" type="primary">Save</bui-button>
      </div>
   </bui-form>
  </bui-frame>
</template> 

<script>
  import _ from 'lodash'
  import {
    BuiIcon,
    BuiButton,
    BuiInput,
    BuiSelect,
    BuiSelectOption,
    BuiForm,
    BuiFrame,
    BuiToolbar
  } from 'components/utils'
  import { mapActions } from 'vuex'
  import countryCode from 'app/countryCode'
  import { deckModel } from 'app/models/models'

  export default {
    name: 'edit-deck',
    computed: {
      override () {
        const decks = this.$store.state.decks.all
        return _.cloneDeep(_.find(decks, {id: this.deckId}) || deckModel())
      },
      isNew () {
        return this.deckId == null
      }
    },
    methods: {
      ...mapActions([
        'addDeck',
        'updateDeck'
      ]),
      save () {
        if (this.isNew) {
          this.addDeck(this.override)
        } else {
          this.updateDeck(this.override)
        }
        this.$router.back()
      },
      cancel () {
        this.$router.back()
      }
    },
    components: {
      BuiButton,
      BuiIcon,
      BuiInput,
      BuiSelect,
      BuiSelectOption,
      BuiFrame,
      BuiForm,
      BuiToolbar
    },
    data () {
      return {
        countryCode,
        deckId: this.$route.params.deckId != null ? parseInt(this.$route.params.deckId) : null
      }
    }
  }
</script>

<style lang="scss" scoped>
@import '~style/variables.scss';

.edit-card {
  padding: 15px;
  background-color: $white;
}
</style>