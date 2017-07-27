/* =========================================================
 * Laramodal v1.0
 * =========================================================
 * Created by Torgheh (https://github.com/torgheh)
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */


(function($) {

    $.fn.laramodal = function() {
        return this.each(function() {

            var event = $(this).prop("tagName") == 'FORM' ? 'submit.laramodal' : 'click.laramodal';
            $(this).off(event);
            $(this).on(event, function(e) {
                e.preventDefault();
                laramodal = new Laramodal($(this));
                laramodal.make();

            });

        });


    };

    $('[data-toggle="laramodal"]').laramodal();

    function Laramodal(target, params) {
        if (params == undefined) {

            params = { container: $('body'), cache: false };

        } else {

            params = { container: params.container || $('body'), cache: params.cache || false };
        }

        this.target = target;
        this.isForm = (target.attr('data-toggle') == 'laramodal-form' || target.prop("tagName") == 'FORM');
        this.data = this.getData();
        this.action = this.getAction();
        this.method = this.getMethod();
        this.cache = params.cache;
        this.modalContainer = params.container;

    };

    Laramodal.prototype.getData = function() {
        if (this.isForm)
            return this.target.serializeArray();

        return {};

    };

    Laramodal.prototype.addData = function(key, value) {
        this.data[key] = value;

    };



    Laramodal.prototype.getAction = function() {
        var action = this.target.attr('data-action');

        if (action) {

            return action;

        } else {

            return this.target.attr('action');
        }

    };

    Laramodal.prototype.setAction = function(action) {
        this.action = action;

    };

    Laramodal.prototype.getMethod = function() {

        if (this.isForm)
            return this.target.attr('method');

        if (this.target.attr('data-method'))
            return this.target.attr('data-method');

        return 'GET';

    };

    Laramodal.prototype.setMethod = function(method) {

        this.method = method;

    };




    Laramodal.prototype.make = function() {

        this.request((function(response) {

            if ($.type(response) == 'string') {
                return this.replaceWholeDocument(response);
            }
            if (response.redirect) {

                return this.redirect(response.redirect);
            }

            this.showModal(response);

        }).bind(this));
    };



    Laramodal.prototype.replaceWholeDocument = function(response) {

        var newDoc = document.open("text/html", "replace");
        newDoc.write(response);
        newDoc.close();
    };

    Laramodal.prototype.redirect = function(url) {

        window.location.replace(url);
    };

    Laramodal.prototype.showModal = function(response) {


        var old = this.modalContainer.find('.modal');
        if (old.length && old.hasClass('in')) {

            old.modal('hide');
            old.on('hidden.bs.modal', (function(e) {

                $(e.target).data('bs.modal', null);
                $(e.target).remove();
                this.makeModal(response);
            }).bind(this));

        } else if (old.length) {

            old.remove();
            old.data('bs.modal', null);
            this.makeModal(response);

        } else {

            this.makeModal(response);
        }

    };


    Laramodal.prototype.makeModal = function(response) {

        modal = $(response.modal);
        this.modalContainer.append(modal);
        modal.modal('show');
        modal.find('[data-toggle="laramodal"]').laramodal();

    };

    Laramodal.prototype.request = function(callback) {

        $.ajax({
            url: this.action,
            type: this.method,
            data: this.data,
            cache: this.cache,
            success: function(response) {

                callback(response);


            },
            error: function(response, res, error) {
                console.log('Laramodal error!: "' + error + '"');

            },
        });
    };

    window.Laramodal = Laramodal;

}(jQuery));