class Confirm {
  constructor(jquery) {
    this.$ = jquery;
    this.okBtnClick = () => {}
    this.black = 'black-v1';
    this.confirm = 'confirm-v1';
    this.addStartEvent();
  }

  addStartEvent() {
    const $ = this.$;
    const _self = this;
    $("body").on("click", `.${this.confirm}-close`, function() {
      _self.closeLoad();
    });
    $("body").on("click", `.${this.confirm}-ok`, function() {
      _self.clickOk();
    });
  }

  clickOk() {
    if (typeof this.okBtnClick === 'function') {
      this.okBtnClick();
    }
    this.closeLoad();
  }

  closeLoad() {
    this.removeFromPage();
  }

  addToPage(message, okBtnClick, okBtnName = 'OK', cancelBtnName = 'Cancel', center = true) {
    const $ = this.$;
    this.setOkFunction(okBtnClick);
    if (!$(`.${this.load}`).length) {
      const confirmButtons = `<button class="ok-dialog ${this.confirm}-ok">${okBtnName}</button><button class="close-dialog ${this.confirm}-close">${cancelBtnName}</button>`;
      $("body").append(`<div class="${this.black}"></div>`);
      $("body").append(`<div class="${this.confirm}"><div class="modal-box${center ? ' center' : ''}"><div class="message">${message}</div><div class="dialog">${confirmButtons}</div></div></div>`);
    }
    this.addScrollHeight();
  }

  removeFromPage() {
    const $ = this.$;
    $(`.${this.black}`).detach();
    $(`.${this.confirm}`).detach();
  }

  addScrollHeight() {
    const $ = this.$;
    const topScroll = parseInt($(window).scrollTop());
    $(`.${this.confirm}`).css('margin-top',`${topScroll}px`);
  }

  setOkFunction(okBtnClick) {
    this.okBtnClick = typeof okBtnClick === 'function' ? okBtnClick : () => {};
  }
}
