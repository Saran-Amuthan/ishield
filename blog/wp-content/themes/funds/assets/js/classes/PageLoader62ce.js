class PageLoader {
  constructor(jquery) {
    this.$ = jquery;
    this.load = 'load-v1';
    this.addStartEvent();
  }

  addStartEvent() {
    const $ = this.$;
    const _self = this;
    $("body").on("click", ".load-v1-close", function() {
      _self.closeLoad();
    });
  }

  closeLoad() {
    this.removeLoad();
  }

  addLoad() {
    const $ = this.$;
    if (!$(`.${this.load}`).length) {
      $("body").append(`<div class="${this.load}"><button class="close load-v1-close">Close ×</button></div>`);
    }
  }

  removeLoad() {
    const $ = this.$;
    $(`.${this.load}`).detach();
  }
}
