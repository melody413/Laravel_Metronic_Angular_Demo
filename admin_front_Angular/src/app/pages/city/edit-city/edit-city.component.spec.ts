import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditCityComponent } from './edit-city.component';

describe('EditCityComponent', () => {
  let component: EditCityComponent;
  let fixture: ComponentFixture<EditCityComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditCityComponent]
    });
    fixture = TestBed.createComponent(EditCityComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
