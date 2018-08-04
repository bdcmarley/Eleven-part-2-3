import React from 'react';
import axios from 'axios';


import Error from 'containers/Alert/Error';
import Success from 'containers/Alert/Success';

import {
    FormGroup,
    ControlLabel,
    FormControl,
    Form,
    Button, } from 'react-bootstrap';

// Cette page nous sert a creer une offre.
class Create extends React.Component {

    constructor(){
        super();
        this.state = {
            error: [],
            success: [],
            name: []
        };
    }
// Lors de la validation du formulaire, cette methode s'enclenche.
    validateForm(){
// Voulent creer une offre, la methode est donc POST.
          axios.post('/offers/new' , {
            title: this.title.value,
            content: this.content.value,
            description: this.description.value,
            price: this.price.value
          });
    }
// Petite function pour nous simplifier notre fomulaire.
    formInput(type, name)
    {
      return (
      <FormGroup>
          <ControlLabel>{name}</ControlLabel>
          <FormControl
              type={type}
              name={name}
              id={'exemple'+name}
              placeholder={name}
              inputRef={ input => this[name] = input }
          />
        </FormGroup>
        );
    }

    render()
    {
// Le formulaire pour creer l'offre, lors de la validation de celui-ci, la methode validateForm se declenche.
        return (
            <div>
                <Form inline onSubmit={ (e) => this.validateForm(e) } >
                    <Error messages={this.state.error}/>
                    <Success messages={this.state.success}/>
                    {this.formInput('text', 'title')}
                    {this.formInput('text', 'content')}
                    {this.formInput('text', 'description')}
                    {this.formInput('number', 'price')}
                    <Button type="submit">Submit</Button>
                </Form>
                <a href="/offers">Home</a>
            </div>

        );
    }
}

export default Create;
