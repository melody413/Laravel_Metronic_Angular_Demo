import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditCountryComponent } from './edit-country.component';

describe('EditCountryComponent', () => {
  let component: EditCountryComponent;
  let fixture: ComponentFixture<EditCountryComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditCountryComponent]
    });
    fixture = TestBed.createComponent(EditCountryComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
