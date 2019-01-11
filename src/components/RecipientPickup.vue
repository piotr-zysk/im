<template>
  <div>
    <div class="recipient_string" v-show="!showMenu" @click="toggleMenu">
      <p>
        <i class="fas fa-angle-double-down"></i>
        <strong> {{$ml.get('recipients') | uppercase}}:</strong>
        {{recipient_string | truncate(600)}}
      </p>
    </div>

    <div class="recipient_pickup" v-show="showMenu">
      <div class="filters">

        <select class="filter" id="listOfClients" @change="filterCandidates">
          <option value="all">{{$ml.get('all_clients')}}</option>
          <option v-for="item in dbcache.clients" :key="item">{{item}}</option>
        </select>

        <select class="filter" id="listOfCampaigns" @change="filterCandidates">
          <option value="all">{{$ml.get('all_campaigns')}}</option>
          <option v-for="item in dbcache.campaigns" :key="item.id" :value="item.id">{{item.name}}</option>
        </select>

        <select class="filter" id="listOfSites" @change="filterCandidates">
          <option value="all">{{$ml.get('all_sites')}}</option>
          <option v-for="item in dbcache.sites" :key="item.id" :value="item.id">{{item.name}}</option>
        </select>

        <select class="filter" id="listOfGroups" @change="filterCandidates">
          <option value="all">{{$ml.get('all_groups')}}</option>
          <option v-for="item in dbcache.groups" :key="item.id" :value="item.id">{{item.name}}</option>
        </select>

      </div>
      <select
        class="listbox"
        id="listOfCandidates"
        @click="oneToRight"
        @keyup.enter="oneToRight"
        multiple
      >
        <option v-for="item1 in listOfCandidates" :key="item1.id">{{item1.name}}</option>
      </select>
      <div class="recipient_transfer">
        <button class="button_toggle_menu" @click="toggleMenu">
          <i class="fas fa-angle-double-up"></i>
        </button>
        <button class="button_small" @click="allToRight">
          <i class="fas fa-angle-double-right"></i>
        </button>
        <button class="button_small_shadow" @click="allToLeft">
          <i class="fas fa-angle-double-left"></i>
        </button>
      </div>

      <select
        class="listbox"
        id="listOfRecipients"
        @click="oneToLeft"
        @keyup.enter="oneToLeft"
        multiple
      >
        <option v-for="item2 in listOfRecipients" :key="item2.id">{{item2.name}}</option>
      </select>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
  name: "NewMessage",
  data() {
    return {
      listOfCandidates: [],
      ListOfCandidatesNotFiltered: [],
      listOfRecipients: [],
      recipient_string: "",
      showMenu: false
    };
  },
  mounted() {
    for (let i = 0; i < this.dbcache.users.length; i++) {
      let x = this.dbcache.users[i];
      let y = "";
      if (
        x.lastName.length > 2 &&
        this.settings.excludedLastNames.indexOf(x.lastName) == -1
      ) {
        y = {
          id: x.id,
          name: x.lastName + " " + x.firstName,
          campaignId: x.campaignId,
          siteId: x.siteId
        };
        this.listOfCandidates.push(y);
        this.ListOfCandidatesNotFiltered.push({
          id: x.id,
          name: x.lastName + " " + x.firstName,
          campaignId: x.campaignId
        });
      }
    }
    this.listOfCandidatesNotFiltered = this.listOfCandidates;
    
    // load recipient for Reply
    for (let i=0; i<this.listOfCandidates.length; i++) {
        if (this.message_store.recipients.includes(this.listOfCandidates[i].id))
          this.listOfRecipients.push(this.listOfCandidates[i]);
      }
    //this.listOfRecipients=this.listOfCandidates; //this.message_store.recipients;
  },
  computed: mapState(["dbcache", "settings", "message_store"]),
  watch: {
    listOfRecipients: function() {
      let x = "";
      //console.log(this.listOfRecipients);
      for (let i = 0; i < this.listOfRecipients.length; i++) {
        if (i > 0) x = x + ", ";
        x = x + this.listOfRecipients[i].name;
      }
      this.recipient_string = x;

    }
  },
  methods: {
    toggleMenu: function() {
      if (this.showMenu) this.showMenu = false;
      else this.showMenu = true;
    },
    isValidCandidate(candidate) {
      let id = candidate.id;

      //clients
      let filter = document.getElementById("listOfClients").value;
      let result = false;
      if (filter == "all") result = true;
      else for (let i = 0; i < this.dbcache.campaigns.length; i++) {
        if (
          filter == this.dbcache.campaigns[i].client &&
          candidate.campaignId == this.dbcache.campaigns[i].id
        ) {
          result = true;
          break;
        }
      }
      if (!result) return result;

      //campaigns
      result = false;
      filter = document.getElementById("listOfCampaigns").value;
      if ((filter=="all") || (filter==candidate.campaignId)) result = true;
      if (!result) return result;

      //sites
      result = false;
      filter = document.getElementById("listOfSites").value;
      if ((filter=="all") || (filter==candidate.siteId)) result = true;
      if (!result) return result;

      //groups:
      filter = document.getElementById("listOfGroups").value;
      result = false;
      if (filter == "all") result = true;
      else for (let i = 0; i < this.dbcache.groupUsers.length; i++) {
        if (
          (filter == this.dbcache.groupUsers[i].groupId) &&
          candidate.id == this.dbcache.groupUsers[i].userId
        ) {
          result = true;
          break;
        }
      }

      return result;
    },
    filterCandidates() {
      let x = "";
      this.listOfCandidates = [];
      for (let i = 0; i < this.listOfCandidatesNotFiltered.length; i++) {
        x = this.listOfCandidatesNotFiltered[i];
        if (this.isValidCandidate(x)) this.listOfCandidates.push(x);
      }
    },
    oneToRight: function() {
      var listbox = document.getElementById("listOfCandidates");

      for (var i = 0; i < this.listOfCandidates.length; i++)
        if (listbox.options[i].selected) {
          if (this.listOfRecipients.indexOf(this.listOfCandidates[i]) == -1)
            this.listOfRecipients.push(this.listOfCandidates[i]);
          let del = this.listOfCandidates.indexOf(this.listOfCandidates[i]);
          listbox.options[i].selected = false;
          this.listOfCandidates.splice(del, 1);
        }

      this.listOfRecipients.sort(function(a, b) {
        if (a.name < b.name) return -1;
        else if (a.name > b.name) return 1;
        else return 0;
      });
    },
    oneToLeft: function() {
      var listbox = document.getElementById("listOfRecipients");

      for (var i = 0; i < this.listOfRecipients.length; i++)
        if (listbox.options[i].selected) {
          if (
            this.isValidCandidate(this.listOfRecipients[i]) &&
            this.listOfCandidates.indexOf(this.listOfRecipients[i]) == -1
          )
            this.listOfCandidates.push(this.listOfRecipients[i]);
          let del = this.listOfRecipients.indexOf(this.listOfRecipients[i]);
          listbox.options[i].selected = false;
          this.listOfRecipients.splice(del, 1);
        }
      this.listOfCandidates.sort(function(a, b) {
        if (a.name < b.name) return -1;
        else if (a.name > b.name) return 1;
        else return 0;
      });
    },
    allToRight: function() {
      for (var i = 0; i < this.listOfCandidates.length; i++) {
        if (this.listOfRecipients.indexOf(this.listOfCandidates[i]) == -1)
          this.listOfRecipients.push(this.listOfCandidates[i]);
      }
      this.listOfCandidates = [];
      this.listOfRecipients.sort(function(a, b) {
        if (a.name < b.name) return -1;
        else if (a.name > b.name) return 1;
        else return 0;
      });
    },
    allToLeft: function() {
      for (var i = 0; i < this.listOfRecipients.length; i++) {
        if (
          this.isValidCandidate(this.listOfRecipients[i]) &&
          this.listOfCandidates.indexOf(this.listOfRecipients[i]) == -1
        )
          this.listOfCandidates.push(this.listOfRecipients[i]);
      }
      this.listOfRecipients = [];
      this.listOfCandidates.sort(function(a, b) {
        if (a.name < b.name) return -1;
        else if (a.name > b.name) return 1;
        else return 0;
      });
    }
  }
};
</script>

<style>
.recipient_pickup {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: center;
  align-items: stretch;
  margin-bottom: 15px;
  padding-bottom: 10px;
  box-shadow: 0 3px 3px #ccc;
}
.listbox {
  width: 200px;
  height: 250px;
  display: block;

  border-radius: 2px;
}
.recipient_transfer {
  display: block;
  width: 130px; /* calc(100%-700px); */
  align-items: center;
}
.recipient_transfer button {
  width: 80%;
  margin: 5px 10%;
  padding: 5px 15px;
  font-size: 150%;
}
.button_toggle_menu,
.button_toggle_menu:hover {
  border: 1px solid transparent;
  background-color: inherit;

  color: #40739e;
  cursor: pointer;
  transition: none;
}
.recipient_string {
  padding: 1px 5px 0 5px;
  box-shadow: 0 3px 3px #ccc;
  cursor: pointer;
}
.filters {
  width: 220px;
}

.filters select {
  margin: 0 10px 20px 10px;
  border-radius: 2px;
  width: 200px;
}
select:last-of-type option {
  font-weight: bold;
}
</style>