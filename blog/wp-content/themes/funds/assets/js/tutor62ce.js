(function($) {
  const pageLoad = new PageLoader($);
  const confirm = new Confirm($);
  $(document).ready(function() {
    $('.update-date-data').each(function() {
      const val = $(this).attr('data-val');
      const format = $(this).attr('data-format');
      if (val) {
        const valDate = moment.unix(val).local();
        if (valDate.isValid()) {
          $(this).html(valDate.format(format || 'M/D/YYYY'));
        }
      }
    });

    if ($('a').hasClass('button-tutor-clear-filter')) {
      $('a.button-tutor-clear-filter').on('click', function(event) {
        event.preventDefault();
        setTimeout(function() {
          window.location.replace(window.location.href.split('?')[ 0 ]);
        }, 5);
      });
    }

    if ($('button').is('.on-click-enroll-now')) {
      $('.on-click-enroll-now').on('click', function(event) {
        event.preventDefault();
        enrollCourseBySubscription(
            $('#enroll-now-tutor-user-id').val(),
            $('#enroll-now-tutor-course-id').val(),
            $('#enroll-now-tutor-token').val(),
        );
      });
    }

    if ($('button').is('.on-click-decline-now')) {
      $('.on-click-decline-now').on('click', function(event) {
        event.preventDefault();
        const declineCourse = () => {
          enrollCourseBySubscription(
              $('#enroll-now-tutor-user-id').val(),
              $('#enroll-now-tutor-course-id').val(),
              $('#enroll-now-tutor-token').val(),
              true
          );
        };
        confirm.addToPage('Are you sure?<br/>You can\'t undo it.', declineCourse, 'Yes', 'No', true);

      });
    }

    if ($('span').hasClass('tutor-next-btn')) {
      $('span.tutor-next-btn.tutor-quiz-answer-next-btn, span.tutor-next-btn.tutor-quiz-submit-btn').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        const parentBox = $(this).closest('.tutor-quiz-btn-group').parent('div').find('.quiz-question-ans-choice-area');
        parentBox.find('input:checked').prop('checked', false);
        $(this).closest('.tutor-quiz-btn-group').find('button[type=submit]').trigger('click');
      });
    }

    if (typeof tutorData === 'object') {
      if ($('select').is('#whatBestDescribesYou')) {
        const screenOption = $('#whatBestDescribesYou').hasClass('tutor-form-lg-option') ? 'lg' : 'md';
        changeWhatBestDescribesYou($('#whatBestDescribesYou').val(), screenOption);

        $('#whatBestDescribesYou').on('change', function() {
          changeWhatBestDescribesYou($(this).val(), screenOption);
        });

        $('#financialProfessionalField').on('change', function() {
          changeFinancialProfessionalField($(this).val(), screenOption);
        });
      }

      if ($('select').is('#whereDidYouHearAboutUs')) {
        const screenOption = $('#whereDidYouHearAboutUs').hasClass('tutor-form-lg-option') ? 'lg' : 'md';
        changeWhereDidYouHearAboutUs($('#whereDidYouHearAboutUs').val(), screenOption);

        $('#whereDidYouHearAboutUs').on('change', function() {
          changeWhereDidYouHearAboutUs($(this).val(), screenOption);
        });
      }
    }
  });

  function changeWhatBestDescribesYou(whatBestDescribesYou, screenOption = 'md') {
    const firstKeyOptionsBestDescribes = tutorData && tutorData.firstKeyOptionsBestDescribes ? tutorData.firstKeyOptionsBestDescribes : false;
    const secondKeyOptionsBestDescribes = tutorData && tutorData.secondKeyOptionsBestDescribes ? tutorData.secondKeyOptionsBestDescribes : false;

    switch (whatBestDescribesYou) {
      case firstKeyOptionsBestDescribes:
        changeWhatBestDescribesYouHide(screenOption);
        $('.financialProfessionalField-col').removeClass('tutor-d-none').addClass('tutor-d-block');
        $('#financialProfessionalField').prop('required', true);
        changeFinancialProfessionalField($('#financialProfessionalField').val(), screenOption);
        break;

      case secondKeyOptionsBestDescribes:
        changeWhatBestDescribesYouHide(screenOption);
        $('.whatBestDescribesYouOtherField-col').removeClass('tutor-d-none').addClass('tutor-d-block');
        $('#whatBestDescribesYouOtherField').prop('required', true);
        break;

      default:
        changeWhatBestDescribesYouHide(screenOption);
        break;
    }
  }

  function changeFinancialProfessionalField(financialProfessionalField, screenOption = 'md') {
    const firstKeyOptionsFinancialProfessional = tutorData && tutorData.firstKeyOptionsFinancialProfessional ? tutorData.firstKeyOptionsFinancialProfessional : false;
    if (financialProfessionalField === firstKeyOptionsFinancialProfessional) {
      $('.fpYourVersionField-col').removeClass('tutor-d-none').addClass('tutor-d-block');
      $('.whatBestDescribesYou-col').removeClass(`tutor-col-${screenOption}-6`).addClass(`tutor-col-${screenOption}-4`);
      $('.financialProfessionalField-col').removeClass(`tutor-col-${screenOption}-6`).addClass(`tutor-col-${screenOption}-4`);
      $('#fpYourVersionField').prop('required', true);
    } else {
      changeFinancialProfessionalFieldHide(screenOption);
    }
  }

  function changeWhatBestDescribesYouHide(screenOption = 'md') {
    $('.financialProfessionalField-col').removeClass('tutor-d-block').addClass('tutor-d-none');
    $('.fpYourVersionField-col').removeClass('tutor-d-block').addClass('tutor-d-none');
    $('.whatBestDescribesYouOtherField-col').removeClass('tutor-d-block').addClass('tutor-d-none');
    $('#financialProfessionalField').prop('required', false);
    $('#whatBestDescribesYouOtherField').prop('required', false);
    changeFinancialProfessionalFieldHide(screenOption);
  }

  function changeFinancialProfessionalFieldHide(screenOption = 'md') {
    $('.fpYourVersionField-col').removeClass('tutor-d-block').addClass('tutor-d-none');
    $('.whatBestDescribesYou-col').removeClass(`tutor-col-${screenOption}-4`).addClass(`tutor-col-${screenOption}-6`);
    $('.financialProfessionalField-col').removeClass(`tutor-col-${screenOption}-4`).addClass(`tutor-col-${screenOption}-6`);
    $('#fpYourVersionField').prop('required', false);
  }

  function changeWhereDidYouHearAboutUs(whereDidYouHearAboutUs, screenOption = 'md') {
    const firstKeyOptionsHearAboutUs = tutorData && tutorData.firstKeyOptionsHearAboutUs ? tutorData.firstKeyOptionsHearAboutUs : false;
    const secondKeyOptionsHearAboutUs = tutorData && tutorData.secondKeyOptionsHearAboutUs ? tutorData.secondKeyOptionsHearAboutUs : false;
    const thirdKeyOptionsHearAboutUs = tutorData && tutorData.thirdKeyOptionsHearAboutUs ? tutorData.thirdKeyOptionsHearAboutUs : false;
    const hideAllField = () => {
      whereDidYouHearAboutUsHideNextField('#aboutUsPartnerWebsiteField', '.aboutUsPartnerWebsite-col', screenOption);
      whereDidYouHearAboutUsHideNextField('#aboutUsSocialMediaField', '.aboutUsSocialMedia-col', screenOption);
      whereDidYouHearAboutUsHideNextField('#aboutUsProvideFieldToTypeInField', '.aboutUsProvideFieldToTypeIn-col', screenOption);
    };

    switch (whereDidYouHearAboutUs){
      case firstKeyOptionsHearAboutUs:
        hideAllField();
        whereDidYouHearAboutUsShowNextField('#aboutUsPartnerWebsiteField', '.aboutUsPartnerWebsite-col', screenOption, false);
        break;
      case secondKeyOptionsHearAboutUs:
        hideAllField();
        whereDidYouHearAboutUsShowNextField('#aboutUsSocialMediaField', '.aboutUsSocialMedia-col', screenOption);
        break;
      case thirdKeyOptionsHearAboutUs:
        hideAllField();
        whereDidYouHearAboutUsShowNextField('#aboutUsProvideFieldToTypeInField', '.aboutUsProvideFieldToTypeIn-col', screenOption);
        break;
      default:
        hideAllField();
        break;
    }
  }

  function whereDidYouHearAboutUsShowNextField(fieldToShow, fieldToShowCol, screenOption = 'md', isRequired = true) {
    $(fieldToShowCol).removeClass('tutor-d-none').addClass('tutor-d-block');
    $(fieldToShow).prop('required', isRequired);
  }

  function whereDidYouHearAboutUsHideNextField(fieldToShow, fieldToShowCol, screenOption = 'md') {
    $(fieldToShowCol).removeClass('tutor-d-block').addClass('tutor-d-none');
    $(fieldToShow).prop('required', false);
  }

  function showHideError(message, error = false, element = '.subscription-error-message') {
    if (error) {
      $(element).html(message).addClass('visible');
      return;
    }
    $(element).html(message || '').removeClass('visible');
  }

  //Enroll course by subscription
  function enrollCourseBySubscription(userId, courseId, token, decline = false) {
    showHideError('');
    pageLoad.addLoad();
    const url = getUrl();
    const nonce = getNonce();

    if (!userId || !courseId || !token || !url || !nonce) {
      showHideError('There is some issues in request. Please try to update this page.', true);
      pageLoad.removeLoad();
      return;
    }

    $.ajax({
      type: 'POST',
      url,
      data: {
        userId,
        courseId,
        token,
        nonce,
        'action': decline ? 'decline_course_by_subscription_action' : 'enroll_course_by_subscription_action',
      },
      success: function(response) {
        const data = JSON.parse(response);
        if (data && data.success && data.result) {
          updatePageQuickly();
          return;
        }

        showHideError(data.result || 'There is some issues in request. Please try to update this page.', true);
        pageLoad.removeLoad();
        return;
      },
      error: function() {
        showHideError('Server error. Please try again.', true);
        pageLoad.removeLoad();
        return;
      },
    });
  }

  function getUrl() {
    return tutorData && tutorData.url ? tutorData.url : null;
  }

  function getNonce() {
    return tutorData && tutorData.nonce ? tutorData.nonce : null;
  }

  function updatePageQuickly() {
    setTimeout(function() {
      window.location.reload();
    }, 1);
  }
})(jQuery);
