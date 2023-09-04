import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditSpecialtyComponent } from './edit-specialty.component';

describe('EditSpecialtyComponent', () => {
  let component: EditSpecialtyComponent;
  let fixture: ComponentFixture<EditSpecialtyComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditSpecialtyComponent]
    });
    fixture = TestBed.createComponent(EditSpecialtyComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
