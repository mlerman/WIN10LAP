import React from 'react';
import Actions from './Actions.js';
import {store} from './store.js';


class Modal extends React.Component {
    store_keys = ['show_modal', 'modal_body', 'modal_header']
    constructor(){
        super()
        this.state = this._get_applicable_global_state()
        store.subscribe(this._store_change_callback.bind(this))
    }
    _store_change_callback(keys){
        if(_.intersection(this.store_keys, keys).length){
            this.setState(this._get_applicable_global_state())
        }
    }

    _get_applicable_global_state(){
        let applicable_state = {}
        for (let k of this.store_keys){
            applicable_state[k] = store._store[k]
        }
        return applicable_state
    }
    render(){
        return (
            <div className={(this.state.show_modal ? 'fullscreen_modal' : 'hidden')}
                ref={(el) => this.fullscreen_node = el}

                onClick={(e)=>{
                        if(e.target === this.fullscreen_node){
                            Actions.toggle_modal_visibility()
                        }
                    }
                }
            >
                <div className='modal_content' onClick={(e)=>e.preventDefault()}>
                    <div>
                        <button type="button" className='close' onClick={Actions.toggle_modal_visibility}>×</button>
                    </div>

                    <h4>{this.state.modal_header}</h4>

                    <div style={{paddingBottom: '20px'}}>
                        {this.state.modal_body}
                    </div>

                    <button style={{float: 'right'}} type="button"
                        className="btn btn-success"
                        onClick={Actions.toggle_modal_visibility}>Close
                    </button>
                    <div style={{paddingBottom: '30px'}}/>
                </div>
            </div>
        )
    }
}

export default Modal

