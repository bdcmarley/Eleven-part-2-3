  import React from 'react';
  import axios from 'axios';
  import PropTypes from 'prop-types';

// Ce component se charge de l'affiche d'une seul offre, le show.
// On aura donc plus de detail sur l'offre.
  class OneOffer extends React.Component {

      constructor() {
          super();
      }

// Ici, on cree une function qui supprimera l'offre lors de son activation.
      handleClick() {
        // On recupere l'id de l'offre concerne.
        var url = window.location.href.split('/');
        // On choisit le bon endpoint.
        url = `/offers/${url[4]}`;
        // La methode est un DELETE.
          axios.delete(url)
          .then(() => {
            // Si tout se passe bien, on retourne a l'accueil.
            document.location.href='/offers';
              });
      }

// Le render affiche donc tout les parametres d'une offre.
// Il y a aussi un boutons qui, lorsqu'on clique dessus, active la function handleClick qui supprimera l'offre.
// Et un lien qui vous enmene vers l'espace de modification de celle-ci.
      render() {
          return (
              <div>
                  <h1>{this.props.offer.title}</h1>
                  <p>{this.props.offer.content}</p>
                  <h3>{this.props.offer.description}</h3>
                  <h3>{this.props.offer.price}</h3>
                  <button onClick={this.handleClick}>delete</button>
                  <a href={`/change_offers/${this.props.offer.id}`}>update</a>

              </div>
          );
      }
  }

  OneOffer.propTypes = {
      offer: PropTypes.object
  };


  export default OneOffer;
